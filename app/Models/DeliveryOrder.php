<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DeliveryOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected static function boot()
    // {
    //     parent::boot();

    //     // KDMPAJM = Kode Material Project AJM
    //     static::creating(function ($model) {
    //         $model->do_no = 'DO/'. 'AJM/O/VII/-'. date('Ymd') . '/' . strtoupper(Str::random(3));
    //     });

    // }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function details()
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }
}
