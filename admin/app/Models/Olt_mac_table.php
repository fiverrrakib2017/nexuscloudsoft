<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olt_mac_table extends Model
{
    use HasFactory;
    protected $fillable = [
        'olt_id',
        'mac_address',
        'vlan',
        'port',
        'type',
        'last_seen'
    ];
}
