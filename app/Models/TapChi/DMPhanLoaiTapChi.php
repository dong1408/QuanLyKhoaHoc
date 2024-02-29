<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMPhanLoaiTapChi extends Model
{
    use HasFactory;

    // relation n-n to tap_chi
    public function tapChis(){
        return $this->belongsToMany('App\Models\TapChi\TapChi', 'tap_chi_d_m_phan_loai_tap_chi', 'id_tapchi');
    }
}
