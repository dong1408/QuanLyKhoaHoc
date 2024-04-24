<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMToChuc extends Model
{
    use HasFactory;

    protected $table = 'd_m_to_chucs';

    protected $fillable = [
        'id',   
        'matochuc',
        'tentochuc',
        'tentochuc_en',
        'website',
        'dienthoai',
        'address',
        'id_address_city',
        'id_address_country',
        'id_phanloaitochuc'
    ];

    // relation 1-n to user
    public function usersByToChuc()
    {
        return $this->hasMany('App\Models\User', 'id_tochuc');
    }

    // relation 1-n to user
    public function userByNoiHoc()
    {
        return $this->hasMany('App\Models\User', 'id_noihoc');
    }

    // inverse to d_m_tinh_thanh
    public function tinhThanh()
    {
        return $this->belongsTo('App\Models\UserInfo\DMTinhThanh', 'id_address_city');
    }

    // inverse to d_m_quoc_gia
    public function quocGia()
    {
        return $this->belongsTo('App\Models\UserInfo\DMQuocGia', 'id_address_country');
    }

    // inverse to d_m_phan_loai_to_chuc
    public function phanLoaiToChuc()
    {
        return $this->belongsTo('App\Models\UserInfo\DMPhanLoaiToChuc', 'id_phanloaitochuc');
    }

    // relation 1-n to d_m_don_vi
    public function donVis()
    {
        return $this->hasMany('App\Models\UserInfo\DMDonVi', 'id_tochuc');
    }

    // relation 1-n to san_pham // san pham co thong tin noi don vi (to chuc) nao khac khong
    public function sanPhams_thongtinnoikhac()
    {
        return $this->hasMany('App\Models\SanPham\SanPham', 'id_thongtinnoikhac');
    }

    // relation 1-n to san_pham // san pham duoc don vi ((to chuc)) tai tro
    public function sanPham_donvitaitro()
    {
        return $this->hasMany('App\Models\SanPham\SanPham', 'id_donvitaitro');
    }

    // relation 1-n to tap_chi (trong truong hop nay thi to chuc co vai tro la don vi chu quan, 1 don vi chu quan co the quan ly nhieu tap chi)
    public function tapChis()
    {
        return $this->hasMany('App\Models\TapChi\TapChi', 'id_donvichuquan');
    }

    // relation 1-n to de_tai (trong vai tro to chuc chu quan)
    public function deTaisChuQuan()
    {
        return $this->hasMany('App\Models\DeTai\DeTai', 'id_tochucchuquan');
    }

    // relation 1-n to de_tai (trong vai tro to chuc hop tac)
    public function deTaisHopTac()
    {
        return $this->hasMany('App\Models\DeTai\DeTai', 'id_tochuchoptac');
    }

    // relation 1-n to nha_xuat_ban (trong vai tro don vi chu quan)
    public function nhaXuatBans(){
        return $this->hasMany('App\Models\NhaXuatBan\NhaXuatBan', 'id_donvichuquan');
    }
}
