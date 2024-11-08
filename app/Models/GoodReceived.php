<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class GoodReceived extends Model
{
    use HasFactory;

    protected $table = 'goods_received';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'tanggal_masuk',
        'no_transaksi',
        'nama_supplier',
        'kode_surat_jalan',
        'nama_barang',
        'spesifikasi_barang',
        'quantity',
        'jenis_stok',
        'keterangan_barang',
        'material_id',
        'consumable_id',
        'tools_id',


    ];

    public function material()
    {
        return $this->belongsTo(Materials::class);
    }

    protected static function boot()
    {
        parent::boot();

        // KDMPAJM = Kode Material Project AJM
        static::creating(function ($model) {
            $model->kode_surat_jalan = 'AJM-' . date('Ymd') . '-KDSJAJM-' . strtoupper(Str::random(3));
        });

    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $material = Materials::find($model->material_id);

            // Cek apakah quantity mencukupi
            if ($material->quantity < $model->quantity) {
                throw new \Exception("Quantity material tidak mencukupi.");
            }
            // // Kurangi quantity di tabel material
            // $material->decrement('quantity', $model->quantity);

            // Menambahkan quantity di tabel material
            $material->increment('quantity', $model->quantity);
        });
    }



}
