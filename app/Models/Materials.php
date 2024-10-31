<?php

namespace App\Models;

use App\Models\Mahasigma;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materials extends Model
{
    use HasFactory;

    // public function mahasigmas()
    // {
    //     return $this->hasMany(Mahasigma::class);
    // }

    protected $table = 'materials';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'nama_material',
        'spesifikasi_material',
        'kode_material',
        'jenis_quantity',
        'quantity',
        'jenis_material',
        'project_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode_material = 'AJM-' . date('Ymd') . '-KDPAJM-' . strtoupper(Str::random(3));
        });
    }
}
