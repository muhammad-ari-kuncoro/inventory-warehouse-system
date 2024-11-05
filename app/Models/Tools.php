<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Tools extends Model
{
    use HasFactory;
    protected $table = 'tools';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'nama_alat',
        'spesifikasi_alat',
        'jenis_quantity',
        'kode_alat',
        'jenis_alat',
        'quantity',
        'tipe_alat'
    ];

    protected static function boot()
    {
        parent::boot();
        // KDMPAJM = Kode Tools Assets AJM
        static::creating(function ($model) {
            $model->kode_alat = 'AJM-' . date('Ymd') . '-KDTAJM-' . strtoupper(Str::random(3));
        });
    }

}
