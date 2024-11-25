<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Tools;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckOutTools extends Model
{
    use HasFactory;

    protected $table = 'check_out_tools'; // Nama tabel
    protected $fillable = [
        'tanggal_pengambilan',
        'bagian_divisi',
        'nama_peminjam_alat',
        'kd_peminjam_tool',
        'tool_id',
        'quantity',
        'jenis_quantity',
        'keterangan_alat',
    ];

    // Relasi ke tabel Tools
    public function tool()
    {
        return $this->belongsTo(Tools::class);
    }



    // Event lifecycle model
    protected static function boot()
    {
        parent::boot();

        // Saat membuat data baru
        static::creating(function ($model) {
            // Ambil tool terkait
            $tool = Tools::find($model->tool_id);

            // Pastikan tool valid dan stok mencukupi
            if ($tool && $tool->quantity >= $model->quantity) {
                // Kurangi stok
                $tool->decrement('quantity', $model->quantity);
            } else {
                // Jika stok tidak mencukupi
                throw new \Exception('Stok Alat tidak mencukupi.');
            }

            // Generate kode tool item
            $model->kd_peminjam_tool = 'AJM-' . date('Ymd') . '-KDPTAJM-' . strtoupper(Str::random(3));
        });

        // Saat memperbarui data
        static::updating(function ($model) {
            // Ambil data tool terkait
            $tool = Tools::find($model->tool_id);
            $originalQuantity = $model->getOriginal('quantity'); // Quantity lama

            if ($tool) {
                // Hitung selisih quantity
                $difference = $model->quantity - $originalQuantity;

                if ($difference > 0) {
                    // Jika ada penambahan quantity, kurangi stok
                    if ($tool->quantity >= $difference) {
                        $tool->decrement('quantity', $difference);
                    } else {
                        throw new \Exception('Stok tool tidak mencukupi untuk perubahan.');
                    }
                } elseif ($difference < 0) {
                    // Jika ada pengurangan quantity, kembalikan stok
                    $tool->increment('quantity', abs($difference));
                }
            }
        });

        // Saat menghapus data
        static::deleting(function ($model) {
            // Ambil tool terkait
            $tool = Tools::find($model->tool_id);

            if ($tool) {
                // Kembalikan stok sesuai quantity yang dihapus
                $tool->increment('quantity', $model->quantity);
            }
        });
    }
}
