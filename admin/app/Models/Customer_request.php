<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'contact',
        'address',
        'package_id',
        'type',
        'message',
        'remark',
        'status',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
