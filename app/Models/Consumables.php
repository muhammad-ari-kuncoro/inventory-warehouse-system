<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Consumables extends Model
{
    use HasFactory;


    protected $table = 'consumables';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'nama_consumable',
        'spesifikasi_consumable',
        'quantity',
        'jenis_quantity',
        'kode_consumable',
        'jenis_consumable',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    protected static function boot()
    {
        parent::boot();
        // KDCAJM = Kode Consumable Project AJM
        static::creating(function ($model) {
            $model->kode_consumable = 'AJM-' . date('Ymd') . '-CPAJM-' . strtoupper(Str::random(3));
        });
    }
}
