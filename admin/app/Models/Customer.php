<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
      use HasFactory, Notifiable;
    protected $fillable = [
        'fullname', 'phone', 'nid', 'address', 'con_charge', 'amount',
        'username', 'password', 'package_id', 'pop_id', 'area_id',
        'router_id', 'lat','lng','status', 'expire_date', 'remarks', 'liabilities', 'is_delete', 'last_seen','mac_address'
    ];
    public function pop(){
        return $this->belongsTo(Pop_branch::class,'pop_id','id');
    }
    public function area(){
        return $this->belongsTo(Pop_area::class,'area_id','id');
    }
    public function package(){
        return $this->belongsTo(Branch_package::class,'package_id','id');
    }
    public function router(){
        return $this->belongsTo(Router::class,'router_id','id');
    }
    public function sub_area()
    {
        return $this->belongsTo(Sub_area::class, 'sub_area_id');
    }
    public function documents()
    {
        return $this->hasMany(\App\Models\Customer_docs::class);
    }
    public function get_profile_pic_url()
    {
        if (!empty($this->profile_pic) && file_exists(public_path($this->profile_pic))) {
            return asset($this->profile_pic);
        }

        return asset('Backend/images/avatar.png');
    }
}
