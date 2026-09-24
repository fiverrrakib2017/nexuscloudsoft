<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'cta_title', 'cta_description', 'cta_btn1_text', 'cta_btn1_url', 'cta_btn2_text', 'cta_btn2_url',
        'site_name', 'about_text', 'phone', 'email',
        'social_description', 'facebook', 'youtube', 'linkedin', 'github',
        'copyright_text', 'developed_by'
    ];
}
