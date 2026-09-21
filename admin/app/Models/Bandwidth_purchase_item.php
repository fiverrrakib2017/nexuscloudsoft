<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth_purchase_item extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_bill_id',
        'bandwidth_item_id',
        'qty',
        'rate',
        'vat',
        'total',
    ];
    public function item(){
        return $this->belongsTo(Bandwidth_item::class, 'bandwidth_item_id','id');
    }

}
