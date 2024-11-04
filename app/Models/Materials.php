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
        'quantity',
        'jenis_quantity',
        'kode_material',
        'jenis_material',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected static function boot()
    {
        parent::boot();

        // KDMPAJM = Kode Material Project AJM
        static::creating(function ($model) {
            $model->kode_material = 'AJM-' . date('Ymd') . '-MPAJM-' . strtoupper(Str::random(3));
        });
    }
}
