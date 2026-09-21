<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snmp_profile extends Model
{
    use HasFactory;
    public function olt()
    {
        return $this->belongsTo(
            Olt_device::class,
            'olt_id'
        );
    }
}
