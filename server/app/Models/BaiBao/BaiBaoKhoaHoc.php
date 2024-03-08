<?php

namespace App\Models\BaiBao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaiBaoKhoaHoc extends Model
{
    use HasFactory;

    protected $table = 'bai_bao_khoa_hocs';

    protected $fillable = [
        'id',
        'id_sanpham',
        'doi',
        'url',
        'received',
        'accepted',
        'published',
        'abstract',
        'keyword',
        'id_tapchi',
        'volume',
        'issue',
        'number',
        'pages',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    // relation 1-1 with san pham,  inverse to san_pham
    public function sanPham()
    {
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }

    // inverse to tap_chi
    public function tapChi()
    {
        return $this->belongsTo('App\Models\TapChi\TapChi', 'id_tapchi');
    }
}
