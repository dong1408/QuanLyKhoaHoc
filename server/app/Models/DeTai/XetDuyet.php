<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XetDuyet extends Model
{
    use HasFactory;
    protected $table = 'xet_duyets';
    protected $fillable = [
        'id',
        'id_sanpham',
        'ngayxetduyet',
        'ketquaxetduyet',
        'sohopdong',
        'ngaykyhopdong',
        'thoihanhopdong',
        'kinhphi'
    ];

    // relation 1-1,  inverse to san_pham
    public function sanPham(){
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }
}
