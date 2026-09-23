<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_title',
        'title',
        'description',
        'btn_text',
        'btn_url',
        'image',
    ];
}
