<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'menu_project';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'nama_project',
        'sub_nama_project',
        'kategori_project',
        'no_jo_project',
        'no_po_project',
        'kode_project',
        'start_date',
        'end_date',
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
