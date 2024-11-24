<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class MaterialIssuance extends Model
{
    use HasFactory;
    protected $table = 'material_issuance';  // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'tanggal_pengambilan',
        'nama_pengambil',
        'bagian_divisi',
        'kd_material_item',
        'material_id',
        'project_id',
        'quantity',
        'jenis_quantity',
        'keterangan_material',
    ];

    public function material()
    {
        return $this->belongsTo(Materials::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected static function boot()
    {
    parent::boot();

    // Saat membuat data baru
    static::creating(function ($model) {
        // Ambil objek Consumables terkait
        $material = Materials::find($model->material_id);

        // Pastikan quantity mencukupi
        if ($material && $material->quantity >= $model->quantity) {
            $material->decrement('quantity', $model->quantity);
        } else {
            // Jika stok tidak mencukupi, batalkan pembuatan model
            throw new \Exception('Insufficient stock for the selected material item.');
        }

        // Generate kode
        $model->kd_material_item = 'AJM-' . date('Ymd') . '-KDMIAJM-' . strtoupper(Str::random(3));
    });

    // Saat memperbarui data
    static::updating(function ($model) {
        // Ambil quantity sebelum perubahan
        $originalQuantity = $model->getOriginal('quantity');

        // Ambil objek Materials terkait
        $material = Materials::find($model->material_id);

        if ($material) {
            // Hitung selisih perubahan quantity
            $difference = $model->quantity - $originalQuantity;

            if ($difference > 0) {
                // Jika quantity bertambah, kurangi stok
                if ($material->quantity >= $difference) {
                    $material->decrement('quantity', $difference);
                } else {
                    // Batalkan jika stok tidak mencukupi
                    throw new \Exception('Insufficient stock for the selected material item.');
                }
            } elseif ($difference < 0) {
                // Jika quantity berkurang, tambahkan kembali stok
                $material->increment('quantity', abs($difference));
            }
        }
    });

    // Saat menghapus data
    static::deleting(function ($model) {
        // Ambil objek Consumables terkait
        $material = Materials::find($model->material_id);

        if ($material) {
            // Kembalikan stok yang digunakan
            $material->increment('quantity', $model->quantity);
        }
    });
}


}
