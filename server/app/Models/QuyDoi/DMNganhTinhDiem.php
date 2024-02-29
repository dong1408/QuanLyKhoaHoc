<?php

namespace App\Models\QuyDoi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMNganhTinhDiem extends Model
{
    use HasFactory;

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
}
