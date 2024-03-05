<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMVaiTroTacGia extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'd_m_vai_tro_tac_gias';

    // relation 1-n to san_pham_tac_gia
    public function sanPhamsTacGias(){
        return $this->hasMany('App\Models\SanPham\SanPhamTacGia', 'id_vaitrotacgia');
    }
}