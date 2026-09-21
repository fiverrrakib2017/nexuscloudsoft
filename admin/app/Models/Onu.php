<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onu extends Model
{
    use HasFactory;
    public function olt(){ return $this->belongsTo(\App\Models\Olt_device::class,'olt_id'); }
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}
