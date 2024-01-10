<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_log_id';
    protected $table = 'document_logs';

    protected $fillable = [
        'action',
        'action_datetime',
        'sys_user',
        'tracking_no',
        'office',
        'remarks'
    ];


    public function document(){
        return $this->hasOne(Document::class, 'tracking_no', 'tracking_no');
    }


}
