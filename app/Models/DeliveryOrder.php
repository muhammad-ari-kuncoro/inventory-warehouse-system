<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class DeliveryOrder extends Model
{
    use HasFactory;
    protected $table = 'delivery_order';  // Sesuaikan dengan nama tabel di database
    // protected $guarded = ['id'];
    protected $fillable = [

        'tanggal_pengiriman',
        'pengirim',
        'penerima',
        'delivery_no',
        'purchase_no',
        'project_id',
        'deskripsi_barang',
        'quantity',
        'jenis_quantity',
        'keterangan_barang'
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
            $model->delivery_no = 'DO/'. 'AJM/O/VII/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
            $model->purchase_no = 'POC' . strtoupper(Str::random(3)). '/';
        });

    }

}
