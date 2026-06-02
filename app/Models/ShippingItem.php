<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;
class ShippingItem extends Model
{
    use HasFactory;

    protected $table = 'shipping_items';
    protected $fillable = [
        'tgl_kirim',
        'pengirim',
        'tujuan',
        'kd_sj_brg_keluar',
        'keterangan_brg',
    ];

    public function details()
    {
        return $this->hasMany(ShippingItemsDetail::class, 'shipping_item_id');
    }

}
