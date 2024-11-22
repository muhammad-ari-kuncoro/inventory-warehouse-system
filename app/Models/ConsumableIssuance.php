<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ConsumableIssuance extends Model
{
    use HasFactory;
    protected $table = 'consumable_issuance';  // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'tanggal_pengambilan',
        'nama_pengambil',
        'kd_consumable_item',
        'consumable_id',
        'quantity',
        'jenis_quantity',
        'keterangan_consumable',
    ];

    public function consumable()
    {
        return $this->belongsTo(Consumables::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil objek terkait
            $consumable = Consumables::find($model->consumable_id);

            // Lakukan decrement hanya jika objek tidak null
            if ($consumable && $consumable->quantity >= $model->quantity) {
                $consumable->increment('quantity', $model->quantity);
            }


            // Generate kode_surat_jalan
            // KDCIAJM = KODE CONSUMABLE ITEM ARMINDO JAYA MANDIRI
            $model->kd_consumable_item = 'AJM-' . date('Ymd') . '-KDCIAJM-' . strtoupper(Str::random(3));
        });


        static::updating(function ($model) {
            // Ambil nilai quantity lama sebelum di-update
            $originalQuantity = $model->getOriginal('quantity');

            // Ambil objek terkait
            $consumable = Consumables::find($model->consumable_id);

            // Perbarui quantity pada objek terkait berdasarkan perubahan

            if ($consumable) {
                $consumable->quantity += ($model->quantity - $originalQuantity);
                $consumable->save();
            }
        });
    }

}
