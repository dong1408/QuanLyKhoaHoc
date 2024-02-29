<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TapChi extends Model
{
    use HasFactory;
    protected $table = 'tap_chis';


    // inverse to nha_xuat_ban
    public function nhaXuatBan()
    {
        return $this->belongsTo('App\Models\NhaXuatBan\NhaXuatBan', 'id_nhaxuatban');
    }

    // inverse to d_m_to_chuc (trong truong hop nay la don vi chu quan)
    public function donViChuQuan()
    {
        return $this->belongsTo('App\Models\UserInfo\DMToChuc', 'id_donvichuquan');
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

    // inverse to user (vai tro la nguoi them tap chi vao he thong)
    public function nguoiThem()
    {
        return $this->belongsTo('App\Models\User', 'id_nguoithem');
    }

    // relation 1-n to tap_chi_khong_cong_nhan
    public function tapChiKhongCongNhans()
    {
        return $this->hasMany('App\Models\TapChi\TapChiKhongCongNhan', 'id_tapchi');
    }

    // relation 1-1 to xep_hang_tap_chi
    public function xepHangTapChi()
    {
        return $this->hasOne('App\Models\TapChi\XepHangTapChi', 'id_tapchi');
    }

    // relation 1-1 to tinh_diem_tap_chi
    public function tinhDiemTapChi()
    {
        return $this->hasOne('App\Models\TapChi\TinhDiemTapChi', 'id_tapchi');
    }

    // relation n-n to d_m_phan_loai_tap_chi
    public function dmPhanLoaiTapChis()
    {
        return $this->belongsToMany('App\Models\TapChi\DMPhanLoaiTapChi', 'tap_chi_d_m_phan_loai_tap_chi', 'id_dmphanloaitapchi');
    }

    // relation n-n to d_m_nganh_theo_hdgs
    public function dmNganhTheoHDGS()
    {
        return $this->belongsToMany('App\Models\TapChi\DMNganhTheoHDGS', 'tap_chi_d_m_nganh_theo_hdgs', 'id_dmnganhtheohdgs');
    }

    // relation 1-n to bai_bao
    public function baiBaos()
    {
        return $this->hasMany('App\Models\BaiBao\BaiBaoKhoaHoc', 'id_tapchi');
    }
}
