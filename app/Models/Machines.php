<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Machines extends Model
{
    use HasFactory;
    protected $table = 'machine_assets';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'kd_mesin_assets',
        'nama_mesin',
        'spesifikasi_mesin',
        'jenis_mesin',
        'quantity',
        'jenis_quantity',
        'harga_mesin',
    ];


    protected static function boot()
    {
        parent::boot();
        // KDCAJM = Kode Consumable Project AJM
        static::creating(function ($model) {
            $model->kd_mesin_assets = 'AJM-' . date('Ymd') . '-KDCAJM-' . strtoupper(Str::random(3));
        });
    }
}
