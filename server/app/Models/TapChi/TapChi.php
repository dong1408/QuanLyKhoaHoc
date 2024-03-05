<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TapChi extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'tap_chis';
    protected $fillable = [
        'id',
        'name',
        'issn',
        'eissn',
        'pissn',
        'website',
        'quocte',
        'id_nhaxuatban',
        'id_donvichuquan',
        'address',
        'id_address_city',
        'id_address_country',
        'trangthai',
        'id_nguoithem',
        'created_at',
        'updated_at'
    ];



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

    // relation 1-n to xep_hang_tap_chi
    public function xepHangTapChis()
    {
        return $this->hasMany('App\Models\TapChi\XepHangTapChi', 'id_tapchi');
    }

    // relation 1-n to tinh_diem_tap_chi
    public function tinhDiemTapChis()
    {
        return $this->hasMany('App\Models\TapChi\TinhDiemTapChi', 'id_tapchi');
    }

    // relation n-n to d_m_phan_loai_tap_chi
    public function dmPhanLoaiTapChis()
    {
        return $this->belongsToMany('App\Models\TapChi\DMPhanLoaiTapChi', 'tap_chi_d_m_phan_loai_tap_chi', 'id_tapchi' ,'id_dmphanloaitapchi');
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
