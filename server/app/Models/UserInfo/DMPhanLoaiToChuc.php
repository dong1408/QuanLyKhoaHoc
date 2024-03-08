<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMPhanLoaiToChuc extends Model
{
    use HasFactory;

    protected $table = 'd_m_phan_loai_to_chucs';

    // relation 1-n to d_m_to_chuc
    public function toChucs()
    {
        return $this->hasMany('App\Models\UserInfo\DMToChuc', 'id_phanloaitochuc');
    }
}
