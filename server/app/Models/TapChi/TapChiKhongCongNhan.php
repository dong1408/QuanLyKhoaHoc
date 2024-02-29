<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapChiKhongCongNhan extends Model
{
    use HasFactory;

    // inverse to tap_chi
    public function tapChi()
    {
        return $this->belongsTo('App\Models\TapChi\TapChi', 'id_tapchi');
    }

    // inverse to user (vai tro la nguoi cap nhat)
    public function nguoiCapNhat()
    {
        return $this->belongsTo('App\Models\User', 'id_nguoicapnhat');
    }
}
