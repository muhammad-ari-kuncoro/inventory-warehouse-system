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
        'kode_surat_jalan',
        'material_id',
        'consumable_id',
        'tools_id',
        'quantity',
        'quantity_jenis',
        'jenis_stok',
        'keterangan_barang',
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate kode_surat_jalan
            $model->kode_surat_jalan = 'AJM-' . date('Ymd') . '-KDSJAJM-' . strtoupper(Str::random(3));

            // Retrieve related models using the IDs
            $material = Materials::find($model->material_id);
            $consumable = Consumables::find($model->consumable_id);
            $tools = Tools::find($model->tools_id);

            // Check if the related records exist
            if (!$material || !$consumable || !$tools) {
                throw new \Exception("Related material, consumable, or tools not found.");
            }

            // Check if the quantity is sufficient for each related item
            if ($material->quantity < $model->quantity) {
                throw new \Exception("Quantity material tidak mencukupi.");
            } elseif ($consumable->quantity < $model->quantity) {
                throw new \Exception("Quantity Consumable tidak mencukupi.");
            } elseif ($tools->quantity < $model->quantity) {
                throw new \Exception("Quantity Alat tidak mencukupi.");
            }

            // Update the quantities in the related tables
            $material->increment('quantity', $model->quantity);
            $consumable->increment('quantity', $model->quantity);
            $tools->increment('quantity', $model->quantity);
        });
    }
}
