<?php

namespace App\Models\QuyDoi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMNganhTinhDiem extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'd_m_nganh_tinh_diems';

    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_nganhtinhdiem');
    }

    // relation 1-n to tinh_diem_tap_chi
    public function tinhDiemTapChi()
    {
        return $this->hasMany('App\Models\TapChi\TinhDiemTapChi', 'id_nganhtinhdiem');
    }

    // relation 1-n to d_m_chuyen_nganh_tinh_diem
    public function chuyenNganhTinhDiems()
    {
        return $this->hasMany('App\Models\QuyDoi\DMChuyenNganhTinhDiem', 'id_nganhtinhdiem');
    }
}
