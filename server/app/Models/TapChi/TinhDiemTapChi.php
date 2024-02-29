<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhDiemTapChi extends Model
{
    use HasFactory;

    // relation 1-1, inverse to tap_chi
    public function tapChi()
    {
        return $this->belongsTo('App\Models\TapChi\TapChi', 'id_tapchi');
    }

    // inverse to d_m_nganh_tinh_diem
    public function nganhTinhDiem()
    {
        return $this->belongsTo('App\Models\QuyDoi\DMNganhTinhDiem', 'id_nganhtinhdiem');
    }

    // inverse to d_m_chuyen_nganh_tinh_diem
    public function chuyenNganhTinhDiem()
    {
        return $this->belongsTo('App\Models\QuyDoi\DMChuyenNganhTinhDiem', 'id_chuyennganhtinhdiem');
    }

    // inverse to user (nguoi cap nhat)
    public function user(){
        return $this->belongsTo('App\Models\User', 'id_nguoicapnhat');
    }
}
