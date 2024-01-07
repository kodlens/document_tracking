<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_id';
    protected $table = 'documents';

    protected $fillable = [
        'user_id',
        'tracking_no',
        'document_name',
        'is_done',
        'route_id',
        'is_forwarded',
        'fowarded_datetime',
        'datetime_done'
    ];

    public function document_tracks(){
        return $this->hasMany(DocumentTrack::class, 'document_id', 'document_id')
            ->with(['office'])
            ->orderBy('order_no', 'asc');
    }


    public function route(){
        return $this->hasOne(DocumentRoute::class, 'route_id', 'route_id');
    }

    public function document_logs(){
        return $this->hasMany(DocumentLog::class, 'tracking_no', 'tracking_no')
            ->orderBy('document_log_id', 'asc');
    }
    

}
