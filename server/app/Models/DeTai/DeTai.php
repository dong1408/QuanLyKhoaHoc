<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeTai extends Model
{
    use HasFactory;

    protected $table = 'de_tais';
    protected $fillable = [
        'id',
        'id_sanpham',
        'maso',
        'ngaydangky',
        'ngoaitruong',
        'truongchutri',
        'id_tochucchuquan',
        'id_loaidetai',
        'detaihoptac',
        'id_tochuchoptac',
        'tylekinhphidonvihoptac',
        'capdetai'
    ];

    // relation 1-1 with san pham,  inverse to san_pham
    public function sanPham()
    {
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }

    // inverse to d_m_to_chuc (to chuc chu quan)
    public function toChucChuQuan()
    {
        return $this->belongsTo('App\Models\UserInfo\DMToChuc', 'id_tochucchuquan');
    }

    // inverse to phan_loai_de_tai
    public function phanLoaiDeTai()
    {
        return $this->belongsTo('App\Models\DeTai\PhanLoaiDeTai', 'id_loaidetai');
    }

    // inverse to d_m_to_chuc (to chuc hop tac)
    public function toChucHopTac()
    {
        return $this->belongsTo('App\Models\UserInfo\DMToChuc', 'id_tochuchoptac');
    }
}
