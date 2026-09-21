<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_permission_history extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'role_name',
        'action',
        'old_permissions',
        'new_permissions',
        'performed_by',
    ];

    protected $casts = [
        'old_permissions' => 'array',
        'new_permissions' => 'array',
    ];
}
