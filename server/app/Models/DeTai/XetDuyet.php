<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XetDuyet extends Model
{
    use HasFactory;
    protected $table = 'xet_duyets';

    // relation 1-1,  inverse to san_pham
    public function sanPham(){
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }
}
