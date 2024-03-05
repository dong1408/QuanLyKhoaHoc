<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanPham extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'san_phams';


    // inverse to d_m_san_pham (categories of product)
    public function dmSanPham()
    {
        return $this->belongsTo('App\Models\SanPham\DMSanPham', 'id_loaisanpham');
    }

    // inverse to d_m_to_chuc // san pham co thong tin noi cong tac don vi (to chuc) khac khong
    public function thongTinNoiKhac()
    {
        return $this->belongsTo('App\Models\UserInfo\DMToChuc', 'id_thongtinnoikhac');
    }

    // inverse to d_m_to_chuc // san pham co nhan tai tro cua don vi (to chuc) nao khac khong
    public function donViTaiTro()
    {
        return $this->belongsTo('App\Models\UserInfo\DmToChuc', 'id_donvitaitro');
    }

    // inverse to user // trong vai tro la nguoi ke khai
    public function nguoiKeKhai()
    {
        return $this->belongsTo('App\Models\User', 'id_nguoikekhai');
    }

    // inverse to user // trong vai tro la nguoi ra soat 
    public function nguoiRaSoat()
    {
        return $this->belongsTo('App\Models\User', 'id_nguoirasoat');
    }

    // relation 1-1 with de tai
    public function deTai()
    {
        return $this->hasOne('App\Models\DeTai\DeTai', 'id_sanpham');
    }

    // relation 1-1 with bai bao
    public function baiBao()
    {
        return $this->hasOne('App\Models\BaiBao\BaiBaoKhoaHoc', 'id_sanpham');
    }

    // relation 1-1 with xet_duyet
    public function xetDuyet()
    {
        return $this->hasOne('App\Models\DeTai\XetDuyet', 'id_sanpham');
    }

    // relation 1-1 with bao_cao_tien_do
    public function baoCaoTienDo()
    {
        return $this->hasOne('App\Models\DeTai\BaoCaoTienDo', 'id_sanpham');
    }

    // relation 1-1 with nghiem_thu
    public function nghiemThu()
    {
        return $this->hasOne('App\Models\DeTai\NghiemThu', 'id_sanpham');
    }

    // relation 1-n to san_pham_tac_gia
    public function sanPhamsTacGias(){
        return $this->hasMany('App\Models\SanPham\SanPhamTacGia', 'id_sanpham');
    }
}
