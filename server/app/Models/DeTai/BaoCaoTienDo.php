<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaoCaoTienDo extends Model
{
    use HasFactory;

    protected $table = 'bao_cao_tien_dos';
    protected $fillable = [
        'id',
        'id_sanpham',
        'ngaynopbaocao',
        'ketquaxet',
        'thoigiangiahan',
        'tenbaocao'
    ];

    // relation 1-1,  inverse to san_pham
    public function sanPham(){
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }
}
