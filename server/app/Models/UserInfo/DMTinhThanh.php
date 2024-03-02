<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMTinhThanh extends Model
{
    use HasFactory;

    protected $table = 'd_m_tinh_thanhs';

    // inverse to d_m_quoc_gia
    public function quocGia()
    {
        return $this->belongsTo('App\Models\UserInfo\DMQuocGia', 'id_quocgia');
    }

    // relation 1-n to d_m_to_chuc
    public function tochucs()
    {
        return $this->hasMany('App\Models\UserInfo\DMToChuc', 'id_address_city');
    }

    // relation 1-n to tap_chi
    public function tapChis()
    {
        return $this->hasMany('App\Models\TapChi\TapChi', 'id_address_city');
    }
}
