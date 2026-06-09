<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\support\Str;

class ConsumableIssuanceDetail extends Model
{
    use HasFactory;
    protected $table = 'consumable_issuance_details';
    protected $guarded = ['id'];


    public function consumable()
    {
        return $this->belongsTo(Consumables::class, 'consumable_id', 'id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         DB::transaction(function () use($model){
    //             $consumable = Consumables::find($model->consumable_id);

    //             if ($consumable && $consumable->quantity >= $model->quantity) {
    //                 $consumable->decrement('quantity', $model->quantity);
    //             } else {
    //                 throw new \Exception('Insufficient stock for the selected consumable item.');
    //             }

    //             $model->kd_consumable_item = 'AJM-' . date('Ymd') . '-KDCIAJM-' . strtoupper(Str::random(3));
    //         });
    //     });

    //     // Saat memperbarui data
    //     static::updating(function ($model) {
    //         DB::transaction(function () use($model){
    //             // Ambil quantity sebelum perubahan
    //             $originalQuantity = $model->getOriginal('quantity');

    //             // Ambil objek Consumables terkait
    //             $consumable = Consumables::find($model->consumable_id);

    //             if ($consumable) {
    //                 // Hitung selisih perubahan quantity
    //                 $difference = $model->quantity - $originalQuantity;

    //                 if ($difference > 0) {
    //                     // Jika quantity bertambah, kurangi stok
    //                     if ($consumable->quantity >= $difference) {
    //                         $consumable->decrement('quantity', $difference);
    //                     } else {
    //                         // Batalkan jika stok tidak mencukupi
    //                         throw new \Exception('Insufficient stock for the selected consumable item.');
    //                     }
    //                 } elseif ($difference < 0) {
    //                     // Jika quantity berkurang, tambahkan kembali stok
    //                     $consumable->increment('quantity', abs($difference));
    //                 }
    //             }
    //         });
    //     });

    //     // Saat menghapus data
    //     static::deleting(function ($model) {
    //         DB::transaction(function () use($model){
    //             // Ambil objek Consumables terkait
    //             $consumable = Consumables::find($model->consumable_id);

    //             if ($consumable) {
    //                 // Kembalikan stok yang digunakan
    //                 $consumable->increment('quantity', $model->quantity);
    //             }
    //         });
    //     });
    // }

}
