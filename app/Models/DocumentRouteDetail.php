<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRouteDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'route_detail_id';
    protected $table = 'route_details';

    protected $fillable = [
        'route_id',
        'order_no',
        'office_id',
        'is_origin',
        'is_last'
    ];


}
