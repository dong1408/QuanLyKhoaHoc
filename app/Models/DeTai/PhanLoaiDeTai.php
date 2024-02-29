<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanLoaiDeTai extends Model
{
    use HasFactory;

    // relation 1-n to de_tai
    public function deTais()
    {
        return $this->hasMany('App\Models\DeTai\DeTai', 'id_loaidetai');
    }

    
}
