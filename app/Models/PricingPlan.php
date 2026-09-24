<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'icon', 'setup_fee', 'setup_label', 
        'theme_color', 'is_featured', 'badge_text', 
        'btn_text', 'btn_link', 'sort_order', 'status'
    ];

    public function tiers()
    {
        return $this->hasMany(PricingTier::class, 'pricing_plan_id')->orderBy('id', 'asc');
    }
}
