<?php

namespace App\Models\BaiBao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaiBaoKhoaHoc extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'bai_bao_khoa_hocs';

    // relation 1-1 with san pham,  inverse to san_pham
    public function sanPham()
    {
        return $this->belongsTo('App\Models\SanPhamm\SanPham', 'id_sanpham');
    }

    // inverse to tap_chi
    public function tapChi()
    {
        return $this->belongsTo('App\Models\TapChi\TapChi', 'id_tapchi');
    }
}
