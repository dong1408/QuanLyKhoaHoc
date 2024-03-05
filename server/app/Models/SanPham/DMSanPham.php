<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMSanPham extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'd_m_san_phams';

    // relation 1-n to san_pham
    public function sanPhams()
    {
        return $this->hasMany('App\Models\SanPham\SanPham', 'id_loaisanpham');
    }
}
