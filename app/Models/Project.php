<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'menu_project';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'nama_project',
        'sub_nama_project',
        'kategori_project',
        'no_jo_project',
        'kode_project'
    ];

    protected static function boot()
    {
        parent::boot();

        // KDPAJM = Kode Project AJM
        static::creating(function ($model) {
            $model->kode_project = 'AJM-' . date('Ymd') . '-KDPAJM-' . strtoupper(Str::random(3));
        });
    }


}
