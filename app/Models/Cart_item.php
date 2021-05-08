<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey= 'id';
    protected $fillable = [
        'cart_id',
        'menu_id',
        'quantity',
    ];
}
