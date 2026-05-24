<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GoodReceived extends Model
{
    use HasFactory;

    protected $table = 'goods_received';

    protected $fillable = [
        'user_id',
        'tanggal_masuk',
        'status',
        'nama_supplier',
        'kode_surat_jalan',
    ];

        public function project()
        {
            return $this->belongsTo(Project::class, 'project_id', 'id');
        }

    public function details()
    {
        return $this->hasMany(GoodReceivedDetail::class, 'good_received_id', 'id');
    }




}
