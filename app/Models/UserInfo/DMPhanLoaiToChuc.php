<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMPhanLoaiToChuc extends Model
{
    use HasFactory;

    // relation 1-n to d_m_to_chuc
    public function toChucs()
    {
        return $this->hasMany('App\Models\UserInfo\DMToChuc', 'id_phanloaitochuc');
    }
}
