<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth_purchase_bill extends Model
{
    use HasFactory;
    public function items(){
        return $this->hasMany(Bandwidth_purchase_item::class, 'purchase_bill_id','id');
    }
    public function upstream()
    {
        return $this->belongsTo(\App\Models\Upstream::class);
    }
}
