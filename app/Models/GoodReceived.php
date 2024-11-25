<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GoodReceived extends Model
{
    use HasFactory;

    protected $table = 'goods_received';  // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'tanggal_masuk',
        'no_transaksi',
        'nama_supplier',
        'jenis_barang',
        'kode_surat_jalan',
        'material_id',
        'consumable_id',
        'tools_id',
        'quantity',
        'quantity_jenis',
        'keterangan_barang',
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class);
    }
    public function consumable()
    {
        return $this->belongsTo(Consumables::class);
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

            // Generate kode_surat_jalan
            $model->kode_surat_jalan = 'AJM-' . date('Ymd') . '-KDSJAJM-' . strtoupper(Str::random(3));
        });

        // Saat memperbarui data
        static::updating(function ($model) {
            // Ambil nilai quantity lama sebelum di-update
            $originalQuantity = $model->getOriginal('quantity');
            $quantityDifference = $model->quantity - $originalQuantity;

            // Ambil objek terkait
            $material = Materials::find($model->material_id);
            $consumable = Consumables::find($model->consumable_id);
            $tools = Tools::find($model->tools_id);

            // Perbarui stok berdasarkan perubahan quantity
            if ($material && $quantityDifference != 0) {
                $quantityDifference > 0
                    ? $material->increment('quantity', $quantityDifference)
                    : $material->decrement('quantity', abs($quantityDifference));
            }
            if ($consumable && $quantityDifference != 0) {
                $quantityDifference > 0
                    ? $consumable->increment('quantity', $quantityDifference)
                    : $consumable->decrement('quantity', abs($quantityDifference));
            }
            if ($tools && $quantityDifference != 0) {
                $quantityDifference > 0
                    ? $tools->increment('quantity', $quantityDifference)
                    : $tools->decrement('quantity', abs($quantityDifference));
            }
            });
    }



}
