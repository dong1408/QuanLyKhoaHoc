<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NghiemThu extends Model
{
    use HasFactory;

    protected $table = 'nghiem_thus';
    protected $fillable = [
        'id',
        'id_sanpham',
        'hoidongnghiemthu',
        'ngaynghiemthu',
        'ketquanghiemthu',
        'ngaycongnhanhoanthanh',
        'soqdcongnhanhoanthanh',
        'thoigiangiahan'
    ];

    // relation 1-1,  inverse to san_pham
    public function sanPham()
    {
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }
}
