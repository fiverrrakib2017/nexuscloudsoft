<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olt_device extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brand',
        'mode',
        'ip_address',
        'port',
        'protocol',
        'snmp_community',
        'snmp_version',
        'username',
        'password',
        'vendor',
        'model',
        'serial_number',
        'firmware_version',
        'location',
        'status',
        'description',
    ];
    public function snmpProfile()
    {
        return $this->hasOne(Snmp_profile::class,'olt_id');
    }
    public function onu(){
        return $this->belongsTo(Olt_data::class,'olt_id');
    }
}
