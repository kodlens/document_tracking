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
        'datetime_done'
    ];

    public function document_tracks(){
        return $this->hasMany(DocumentTrack::class, 'document_id', 'document_id')
            ->with(['office']);
    }


    public function route(){
        return $this->hasOne(DocumentRoute::class, 'route_id', 'route_id');
    }

}
