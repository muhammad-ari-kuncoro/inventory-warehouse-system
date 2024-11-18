<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;
class ShippingItem extends Model
{
    use HasFactory;

    protected $table = 'shipping_items';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'tgl_kirim',
        'pengirim',
        'tujuan',
        'kd_sj_brg_keluar',
        'deskripsi_brg',
        'quantity',
        'jenis_quantity',
        'keterangan_brg',
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
            $model->kd_sj_brg_keluar = 'AJM-' . date('Ymd') . '-KDSJBKAJM-' . strtoupper(Str::random(3));
        });
    }
}
