<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth_item extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Bandwidth_categories::class, 'category_id','id');
    }
}
