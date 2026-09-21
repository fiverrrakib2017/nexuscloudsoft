<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_area extends Model
{
    use HasFactory;
    public function area()
    {
        return $this->belongsTo(Pop_area::class, 'area_id');
    }
}
