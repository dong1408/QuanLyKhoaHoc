<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMQuocGia extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'd_m_quoc_gias';

    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_quoctich');
    }

    // relation 1-n to d_m_tinh_thanh
    public function tinhThanhs()
    {
        return $this->hasMany('App\Models\UserInfo\DMTinhThanh', 'id_quocgia');
    }

    // relation 1-n to d_m_to_chuc
    public function toChucs()
    {
        return $this->hasMany('App\Models\UserInfo\DMToChuc', 'id_address_country');
    }

    // relation 1-n to tap_chi
    public function tapChis()
    {
        return $this->hasMany('App\Models\UserInfo\DMQuocGia', 'id_address_country');
    }

    // relation 1-n to nhaXuatBan
    public function nhaXuatBans()
    {
        return $this->hasMany('App\Models\NhaXuatBan\NhaXuatBan', 'id_address_country');
    }
}
