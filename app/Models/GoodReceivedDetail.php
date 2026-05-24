<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Materials;
use App\Models\Consumables;
use App\Models\machine;
class GoodReceivedDetail extends Model
{
    use HasFactory;
    protected $table = 'good_received_detail';
    protected $fillable = [
        'jenis_barang',
        'material_id',
        'consumable_id',
        'machine_id',
        'quantity',
        'quantity_jenis',
        'keterangan_barang',
    ];
    public function material()
    {
        return $this->belongsTo(Materials::class, 'material_id', 'id');
    }
    public function consumable()
    {
        return $this->belongsTo(Consumables::class, 'consumable_id', 'id');
    }
    public function machine()
    {
        return $this->belongsTo(Machines::class, 'machine_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $material       = Materials::find($model->material_id);
            $consumable     = Consumables::find($model->consumable_id);
            $machine        = Machines::find($model->machine_id);
            if ($material) {
                $material->increment('quantity', $model->quantity);
            }
            if ($consumable) {
                $consumable->increment('quantity', $model->quantity);
            }
            if ($machine) {
                $machine->increment('quantity', $model->quantity);
            }
        });
    }
}
