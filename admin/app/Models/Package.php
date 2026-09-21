<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'pool_id',
        'name',
        'price'
    ];
    public function pool()
    {
        return $this->belongsTo(Ip_pools::class,'pool_id');
    }
    // public function customers()
    // {
    //     return $this->hasMany(Customer::class, 'package_id');
    // }
    public function branch_packages()
    {
        return $this->hasMany(Branch_package::class, 'package_id');
    }
    public function customers()
    {
        return $this->hasManyThrough(
            Customer::class,
            Branch_package::class,
            'package_id',
            'package_id',
            'id',
            'id'
        );
    }
}
