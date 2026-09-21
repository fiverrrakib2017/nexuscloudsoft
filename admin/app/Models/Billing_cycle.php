<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing_cycle extends Model
{
    use HasFactory;
    protected $fillable=['pop_id','billing_cycle'];
}
