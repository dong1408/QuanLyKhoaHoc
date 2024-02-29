<?php

namespace App\Models\SanPham;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMSanPham extends Model
{
    use HasFactory;

    // relation 1-n to san_pham
    public function sanPhams()
    {
        return $this->hasMany('App\Models\SanPham\SanPham', 'id_loaisanpham');
    }
}
