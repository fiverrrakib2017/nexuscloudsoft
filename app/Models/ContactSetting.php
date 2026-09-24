<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'sub_title',
        'address_line1', 'address_line2',
        'phone1', 'phone2',
        'email1', 'email2',
        'open_hours_days', 'open_hours_time'
    ];
}
