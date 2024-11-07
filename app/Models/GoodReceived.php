<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'keterangan_barang'

    ];



}
