<?php

namespace App\Models\DeTai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhanLoaiDeTai extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'phan_loai_de_tais';

    // relation 1-n to de_tai
    public function deTais()
    {
        return $this->hasMany('App\Models\DeTai\DeTai', 'id_loaidetai');
    }

    
}
