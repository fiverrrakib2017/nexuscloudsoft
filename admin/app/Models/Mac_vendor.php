<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mac_vendor extends Model
{
    use HasFactory;
    protected $fillable = ['prefix', 'vendor_name'];

}
