<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pop_area extends Model
{
    use HasFactory;
    public function pop()
    {
        return $this->belongsTo(Pop_branch::class, 'pop_id');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class, 'pop_id', 'pop_id');
    }
}
