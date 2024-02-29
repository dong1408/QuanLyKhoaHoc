<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMVaiTroTacGia extends Model
{
    use HasFactory;

    // relation 1-n to san_pham_tac_gia
    public function sanPhamsTacGias(){
        return $this->hasMany('App\Models\SanPham\SanPhamTacGia', 'id_vaitrotacgia');
    }
}