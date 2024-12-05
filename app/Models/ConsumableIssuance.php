<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ConsumableIssuance extends Model
{
    use HasFactory;
    protected $table = 'consumable_issuance';  // Sesuaikan dengan nama tabel di database
    protected $guarded = [];

    public function consumable()
    {
        return $this->belongsTo(Consumables::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        // Saat membuat data baru
        static::creating(function ($model) {
            DB::transaction(function () use($model){
                // Ambil objek Consumables terkait
                $consumable = Consumables::find($model->consumable_id);
    
                // Pastikan quantity mencukupi
                if ($consumable && $consumable->quantity >= $model->quantity) {
                    $consumable->decrement('quantity', $model->quantity);
                } else {
                    // Jika stok tidak mencukupi, batalkan pembuatan model
                    throw new \Exception('Insufficient stock for the selected consumable item.');
                }
    
                // Generate kode_surat_jalan
                // KDCIAJM = KODE CONSUMABLE ISSUANCE (PENGAMBILAN CONSUMABLE) AJM
                $model->kd_consumable_item = 'AJM-' . date('Ymd') . '-KDCIAJM-' . strtoupper(Str::random(3));
            });
        });

        // Saat memperbarui data
        static::updating(function ($model) {
            DB::transaction(function () use($model){
                // Ambil quantity sebelum perubahan
                $originalQuantity = $model->getOriginal('quantity');
    
                // Ambil objek Consumables terkait
                $consumable = Consumables::find($model->consumable_id);
    
                if ($consumable) {
                    // Hitung selisih perubahan quantity
                    $difference = $model->quantity - $originalQuantity;
    
                    if ($difference > 0) {
                        // Jika quantity bertambah, kurangi stok
                        if ($consumable->quantity >= $difference) {
                            $consumable->decrement('quantity', $difference);
                        } else {
                            // Batalkan jika stok tidak mencukupi
                            throw new \Exception('Insufficient stock for the selected consumable item.');
                        }
                    } elseif ($difference < 0) {
                        // Jika quantity berkurang, tambahkan kembali stok
                        $consumable->increment('quantity', abs($difference));
                    }
                }
            });
        });

        // Saat menghapus data
        static::deleting(function ($model) {
            DB::transaction(function () use($model){
                // Ambil objek Consumables terkait
                $consumable = Consumables::find($model->consumable_id);
    
                if ($consumable) {
                    // Kembalikan stok yang digunakan
                    $consumable->increment('quantity', $model->quantity);
                }
            });
        });
    }

}
