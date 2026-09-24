<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'icon', 'color_class', 'btn_text', 'btn_link', 'status'];
}
