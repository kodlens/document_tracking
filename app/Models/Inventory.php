<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    protected $primaryKey = 'inventory_id';
    protected $fillable = [
        'item_id', 'qty'
    ];

    public function item(){
        return $this->hasOne(Item::class, 'item_id', 'item_id');
    }

}
