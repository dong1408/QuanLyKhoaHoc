<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaoCaoTienDo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ba0_cao_tien_dos';

    // relation 1-1,  inverse to san_pham
    public function sanPham(){
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }
}
