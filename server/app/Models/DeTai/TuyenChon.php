<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuyenChon extends Model
{
    use HasFactory;
    protected $table = 'tuyen_chons';

    protected $fillable = [
        'id',
        'id_sanpham',
        'ketquatuyenchon',
        'lydo'
    ];

    // relation 1-1,  inverse to san_pham
    public function sanPham()
    {
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }
}
