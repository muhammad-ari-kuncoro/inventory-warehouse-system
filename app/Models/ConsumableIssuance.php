<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ConsumableIssuance extends Model
{
    use HasFactory;
    protected $table = 'consumable_issuance_header';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(ConsumableIssuanceDetail::class, 'header_id','id');
    }





}
