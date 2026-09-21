<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pop_branch extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'parent_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔹 Parent POP
    public function parent()
    {
        return $this->belongsTo(Pop_branch::class, 'parent_id');
    }

    // 🔹 Child POPs
    public function children()
    {
        return $this->hasMany(Pop_branch::class, 'parent_id');
    }
}
