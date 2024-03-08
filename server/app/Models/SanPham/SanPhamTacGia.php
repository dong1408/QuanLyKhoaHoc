<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanPhamTacGia extends Model
{
    use HasFactory;

    protected $table = 'san_pham_tac_gias';

    protected $fillable = [
        'id',
        'id_sanpham',
        'id_tacgia',
        'id_vaitrotacgia',
        'thutu',
        'tyledonggop',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

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
        return $this->belongsTo('App\Models\SanPham\DMVaiTroTacGia', 'id_vaitrotacgia');
    }
}
