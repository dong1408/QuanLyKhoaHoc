<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamTacGia extends Model
{
    use HasFactory;

    // inverse tac gia (user)
    public function tacGia()
    {
        return $this->belongsTo('App\Models\User', 'id_tacgia');
    }

    // inverse san pham
    public function sanPham()
    {
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }

    // inverse d_m_vai_tro_tac_gia
    public function vaiTroTacGia()
    {
        return $this->belongsTo('App\Models\SanPham\VaiTroTacGia', 'id_vaitrotacgia');
    }
}
