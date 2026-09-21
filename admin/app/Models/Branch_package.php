<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch_package extends Model
{
    use HasFactory;

    public function pop_branch()
    {
        return $this->belongsTo(Pop_branch::class, 'pop_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
