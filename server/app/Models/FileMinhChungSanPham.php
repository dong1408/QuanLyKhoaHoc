<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMinhChungSanPham extends Model
{
    use HasFactory;
    protected $table = 'file_minh_chung_san_phams';
    protected $fillable = [
        'id',
        'id_sanpham',
        'loaiminhchung',
        'url',
        'created_at',
        'updated_at'
    ];

    public function sanPham(){
        return $this->belongsTo('App\Models\SanPham\SanPham', 'id_sanpham');
    }

}
