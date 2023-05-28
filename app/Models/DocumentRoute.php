<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRoute extends Model
{
    use HasFactory;


    protected $primaryKey = 'route_id';
    protected $table = 'routes';

    protected $fillable = [
        'route_name',
        'remarks',
    ];

    public function route_details(){
        return $this->hasMany(DocumentRouteDetail::class, 'route_id', 'route_id')
            ->leftJoin('offices','route_details.office_id', 'offices.office_id')
            ->orderBy('route_details.order_no', 'asc');
    }



}
