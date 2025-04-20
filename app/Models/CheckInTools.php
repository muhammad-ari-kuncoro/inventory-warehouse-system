<?php

namespace App\Models;

use App\Models\Tools;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckInTools extends Model
{
    use HasFactory;
    protected $table = 'check_in_tools'; // Nama tabel
    protected $guarded = [];

    // Relasi ke tabel Tools
    public function tool()
    {
        return $this->belongsTo(Tools::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pengembalian() {
        return $this->hasOne(CheckOutTools::class, 'checkout_tool_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil objek Tools terkait
            $tools = Tools::find($model->tool_id);

            if ($tools) {
                // Tambahkan stok
                $tools->increment('quantity', $model->quantity);
            }

            // Generate kode pengembalian alat
            $model->kd_pengembalian_alat = 'AJM-' . date('Ymd') . '-KDPTTAJM-' . strtoupper(Str::random(3));
        });


        // Saat memperbarui data
        static::updating(function ($model) {
            // Ambil nilai quantity lama
            $originalQuantity = $model->getOriginal('quantity');
            $quantityDifference = $model->quantity - $originalQuantity;

            // Ambil objek Tools terkait
            $tools = Tools::find($model->tool_id);

            if ($tools && $quantityDifference != 0) {
                // Perbarui stok berdasarkan selisih quantity
                $quantityDifference > 0
                    ? $tools->increment('quantity', $quantityDifference)
                    : $tools->decrement('quantity', abs($quantityDifference));
            }
        });

    }







}
