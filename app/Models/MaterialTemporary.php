<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTemporary extends Model
{
    use HasFactory;

    protected $table = 'material_temporaries';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'kd_material_temporary',
        'nm_material_temporary',
        'spesifikasi_material_temporary',
        'quantity_temporary',
        'jenis_quantity',
        'jenis_material',
    ];

    protected static function boot()
    {
        parent::boot();

        // KDPAJM = Kode Project AJM
        static::creating(function ($model) {
            $model->kd_material_temporary = 'AJM-' . date('Ymd') . '-KDMT-' . strtoupper(Str::random(3));
        });
    }
}
