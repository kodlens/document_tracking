<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_ins';
    protected $primaryKey = 'stock_in_id';

    protected $fillable = [
        'item_id', 'qty_in', 'price', 'stock_in_date'
    ];


    public function item(){
        return $this->hasOne(Item::class, 'item_id', 'item_id');
    }

}
