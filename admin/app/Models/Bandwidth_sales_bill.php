<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth_sales_bill extends Model
{
    use HasFactory;
    public function items(){
        return $this->hasMany(Bandwidth_sales_item::class, 'sales_bill_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(\App\Models\Bandwidth_customer::class, 'customer_id', 'id');
    }
}
