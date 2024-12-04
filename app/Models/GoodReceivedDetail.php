<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Materials;
use App\Models\Consumables;
use App\Models\Tools;
class GoodReceivedDetail extends Model
{
    use HasFactory;
    protected $table = 'good_received_detail';
    protected $fillable = [
        'jenis_barang',
        'material_id',
        'consumable_id',
        'tools_id',
        'quantity',
        'quantity_jenis',
        'keterangan_barang',
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class, 'material_id', 'id');
    }
    public function consumable()
    {
        return $this->belongsTo(Consumables::class, 'consumable_id', 'id');
    }
    public function tool()
    {
        return $this->belongsTo(Tools::class, 'tools_id', 'id'); // Pastikan 'tools_id' benar
    }





    protected static function boot()
    {
        parent::boot();

        // Saat membuat data baru
        static::creating(function ($model) {
            // Ambil objek terkait
            $material = Materials::find($model->material_id);
            $consumable = Consumables::find($model->consumable_id);
            $tools = Tools::find($model->tools_id);

            // Lakukan increment stok
            if ($material) {
                $material->increment('quantity', $model->quantity);
            }
            if ($consumable) {
                $consumable->increment('quantity', $model->quantity);
            }
            if ($tools) {
                $tools->increment('quantity', $model->quantity);
            }


        });

        // // Saat memperbarui data
        // static::updating(function ($model) {
        //     // Ambil nilai quantity lama sebelum di-update
        //     $originalQuantity = $model->getOriginal('quantity');
        //     $quantityDifference = $model->quantity - $originalQuantity;

        //     // Ambil objek terkait
        //     $material = Materials::find($model->material_id);
        //     $consumable = Consumables::find($model->consumable_id);
        //     $tools = Tools::find($model->tools_id);

        //     // Perbarui stok berdasarkan perubahan quantity
        //     if ($material && $quantityDifference != 0) {
        //         $quantityDifference > 0
        //             ? $material->increment('quantity', $quantityDifference)
        //             : $material->decrement('quantity', abs($quantityDifference));
        //     }
        //     if ($consumable && $quantityDifference != 0) {
        //         $quantityDifference > 0
        //             ? $consumable->increment('quantity', $quantityDifference)
        //             : $consumable->decrement('quantity', abs($quantityDifference));
        //     }
        //     if ($tools && $quantityDifference != 0) {
        //         $quantityDifference > 0
        //             ? $tools->increment('quantity', $quantityDifference)
        //             : $tools->decrement('quantity', abs($quantityDifference));
        //     }
        //     });
    }
}
