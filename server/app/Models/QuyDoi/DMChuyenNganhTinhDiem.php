<?php

namespace App\Models\QuyDoi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMChuyenNganhTinhDiem extends Model
{
    use HasFactory;

    protected $table = 'd_m_chuyen_nganh_tinh_diems';

    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_chuyennganhtinhdiem');
    }

    // relation 1-n to tinh_diem_tap_chi
    public function tinhDiemTapChis(){
        return $this->hasMany('App\Models\TapChi\TinhDiemTapChi', 'id_chuyennganhtinhdiem');
    }

    // relation inverse to nganh_tinh_diem
    public function nganhTinhDiem(){
        return $this->belongsTo('App\Models\QuyDoi\DMNganhTinhDiem', 'id_nganhtinhdiem');
    }
}
