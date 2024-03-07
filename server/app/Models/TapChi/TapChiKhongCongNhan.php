<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TapChiKhongCongNhan extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'tap_chi_khong_cong_nhans';
    protected $fillable = [
        'id',
        'id_tapchi',
        'khongduoccongnhan',
        'ghichu',
        'id_nguoicapnhat',
        'created_at',
        'updated_at'
    ];

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
