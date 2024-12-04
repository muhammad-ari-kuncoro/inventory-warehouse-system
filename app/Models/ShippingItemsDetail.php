<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingItemsDetail extends Model
{
    use HasFactory;

    protected $table = 'shipping_items_detail';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'shipping_items_id',
        'item_names',
        'quantity',
        'quantity_type',
        'description_items',
    ];

}
