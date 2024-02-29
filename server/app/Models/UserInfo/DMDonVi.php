<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMDonVi extends Model
{
    use HasFactory;


    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_donvi');
    }

    // inverse to d_m_to_chuc
    public function toChuc(){
        return $this->belongsTo('App\Models\UserInfo', 'id_tochuc');
    }
}
