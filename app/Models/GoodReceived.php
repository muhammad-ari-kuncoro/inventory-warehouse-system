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
        return $this->belongsTo(Tools::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil objek terkait
            $material = Materials::find($model->material_id);
            $consumable = Consumables::find($model->consumable_id);
            $tools = Tools::find($model->tools_id);

            // Lakukan decrement hanya jika objek tidak null
            if ($material && $material->quantity <= $model->quantity) {
                $material->increment('quantity', $model->quantity);
            }
            if ($consumable && $consumable->quantity <= $model->quantity) {
                $consumable->increment('quantity', $model->quantity);
            }
            if ($tools && $tools->quantity <= $model->quantity) {
                $tools->increment('quantity', $model->quantity);
            }

            // Generate kode_surat_jalan
            $model->kode_surat_jalan = 'AJM-' . date('Ymd') . '-KDSJAJM-' . strtoupper(Str::random(3));
        });


        static::updating(function ($model) {
            // Ambil nilai quantity lama sebelum di-update
            $originalQuantity = $model->getOriginal('quantity');

            // Ambil objek terkait
            $material = Materials::find($model->material_id);
            $consumable = Consumables::find($model->consumable_id);
            $tools = Tools::find($model->tools_id);

            // Perbarui quantity pada objek terkait berdasarkan perubahan
            if ($material) {
                $material->quantity += ($model->quantity + $originalQuantity);
                $material->save();
            }
            if ($consumable) {
                $consumable->quantity += ($model->quantity + $originalQuantity);
                $consumable->save();
            }
            if ($tools) {
                $tools->quantity += ($model->quantity + $originalQuantity);
                $tools->save();
            }
        });
    }


}
