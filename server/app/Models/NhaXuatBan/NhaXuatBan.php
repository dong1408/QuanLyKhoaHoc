<?php

namespace App\Models\NhaXuatBan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhaXuatBan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'nha_xuat_bans';

    // relation 1-n to tap_chi
    public function tapChis()
    {
        return $this->hasMany('App\Models\TapChi\TapChi', 'id_nhaxuatban');
    }

    // relation inverse to d_m_tinh_thanh
    public function tinhThanh()
    {
        return $this->belongsTo('App\Models\UserInfo\DMTinhThanh', 'id_address_city');
    }

    // relation inverse to d_m_quoc_gia
    public function quocGia()
    {
        return $this->belongsTo('App\Models\UserInfo\DMQuocGia', 'id_address_country');
    }

    // relation inverse to d_m_to_chuc 
    public function donViChuQuan(){
        return $this->belongsTo('App\Models\UserInfo\DNToChuc', 'id_donvichuquan');
    }

    // relation inverse to user -- nguoi them
    public function nguoiThem(){
        return $this->belongsTo('App\Models\User', 'id_nguoithem');
    }
}
