<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MaterialIssuance extends Model
{
    use HasFactory;

    protected $table = 'material_issuance'; // Nama tabel
    protected $guarded = [];

    // Relasi ke tabel materials
    public function material()
    {
        return $this->belongsTo(Materials::class);
    }

    // Relasi ke tabel project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Event lifecycle model
    protected static function boot()
    {
        parent::boot();

        // Saat membuat data baru
        static::creating(function ($model) {
            // Ambil material terkait
            $material = Materials::find($model->material_id);

            // Pastikan material valid dan stok mencukupi
            if ($material && $material->quantity >= $model->quantity) {
                // Kurangi stok
                $material->decrement('quantity', $model->quantity);
            } else {
                // Jika stok tidak mencukupi
                throw new \Exception('Stok material tidak mencukupi.');
            }

            // Generate kode material item
            $model->kd_material_item = 'AJM-' . date('Ymd') . '-KDMIAJM-' . strtoupper(Str::random(3));
        });

        // Saat memperbarui data
        static::updating(function ($model) {
            // Ambil data material terkait
            $material = Materials::find($model->material_id);
            $originalQuantity = $model->getOriginal('quantity'); // Quantity lama

            if ($material) {
                // Hitung selisih quantity
                $difference = $model->quantity - $originalQuantity;

                if ($difference > 0) {
                    // Jika ada penambahan quantity, kurangi stok
                    if ($material->quantity >= $difference) {
                        $material->decrement('quantity', $difference);
                    } else {
                        throw new \Exception('Stok material tidak mencukupi untuk perubahan.');
                    }
                } elseif ($difference < 0) {
                    // Jika ada pengurangan quantity, kembalikan stok
                    $material->increment('quantity', abs($difference));
                }
            }
        });

        // Saat menghapus data
        static::deleting(function ($model) {
            // Ambil material terkait
            $material = Materials::find($model->material_id);

            if ($material) {
                // Kembalikan stok sesuai quantity yang dihapus
                $material->increment('quantity', $model->quantity);
            }
        });
    }
}
