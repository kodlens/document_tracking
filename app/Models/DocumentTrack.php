<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTrack extends Model
{
    use HasFactory;


    protected $primaryKey = 'document_track_id';
    protected $table = 'document_tracks';

    protected $fillable = [
        'tracking_no',
        'document_id',
        'route_id',
        'route_detail_id',
        'office_id',
        'order_no',
        'is_origin','is_last',
        'is_received', 'datetime_received', 'receive_remarks',
        'is_process', 'dateteime_process', 'process_remarks',
        'is_done', 'datetime_done', 'done_remarks',
        'is_forwarded', 'datetime_forwarded', 'forward_remarks',
    ];

    public function office(){
        return $this->hasOne(Office::class, 'office_id', 'office_id');
    }

    public function document(){
        return $this->belongsTo(Document::class, 'document_id', 'document_id');
    }
}
