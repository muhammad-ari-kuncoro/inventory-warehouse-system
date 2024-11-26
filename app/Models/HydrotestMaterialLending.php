<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class HydrotestMaterialLending extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'hydrotest_material_lending'; // Nama tabel
    protected $fillable = [
        'tgl_pinjam_material',
        'bagian_divisi',
        'nama_peminjam',
        'kd_hydrotest_material_lending',
        'material_id',
        'quantity',
        'jenis_quantity',
        'jenis_material',
        'keterangan_material',
    ];

    // Relasi ke tabel Materials
    public function material()
    {
        return $this->belongsTo(Materials::class);
    }



    // Event lifecycle model
    protected static function boot()
    {
        parent::boot();

        // Saat membuat data baru
        static::creating(function ($model) {
            // Ambil materialHydrotest terkait
            $materialHydrotest = Materials::find($model->material_id);

            // Pastikan materialHydrotest valid dan stok mencukupi
            if ($materialHydrotest && $materialHydrotest->quantity >= $model->quantity) {
                // Kurangi stok
                $materialHydrotest->decrement('quantity', $model->quantity);
            } else {
                // Jika stok tidak mencukupi
                throw new \Exception('Stok Alat tidak mencukupi.');
            }

            // Generate kode materialHydrotest item
            $model->kd_hydrotest_material_lending = 'AJM-' . date('Ymd') . '-KDPMAJM-' . strtoupper(Str::random(3));
        });

        // Saat memperbarui data
        static::updating(function ($model) {
            // Ambil data materialHydrotest terkait
            $materialHydrotest = Materials::find($model->material_id);
            $originalQuantity = $model->getOriginal('quantity'); // Quantity lama

            if ($materialHydrotest) {
                // Hitung selisih quantity
                $difference = $model->quantity - $originalQuantity;

                if ($difference > 0) {
                    // Jika ada penambahan quantity, kurangi stok
                    if ($materialHydrotest->quantity >= $difference) {
                        $materialHydrotest->decrement('quantity', $difference);
                    } else {
                        // Berikan flash data jika stok tidak mencukupi
                        return redirect()->route('hydrotest-material-lending.index  ')->with('error', 'Data tidak bisa ditambahkan Dikarenakan Habis!');
                    }
                } elseif ($difference < 0) {
                    // Jika ada pengurangan quantity, kembalikan stok
                    $materialHydrotest->increment('quantity', abs($difference));
                }

            }
        });

        // Saat menghapus data
        static::deleting(function ($model) {
            // Ambil materialHydrotest terkait
            $materialHydrotest = Materials::find($model->material_id);

            if ($materialHydrotest) {
                // Kembalikan stok sesuai quantity yang dihapus
                $materialHydrotest->increment('quantity', $model->quantity);
            }
        });
    }
}
