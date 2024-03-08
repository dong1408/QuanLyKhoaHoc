<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMChuyenMon extends Model
{
    use HasFactory;

    protected $table = 'd_m_chuyen_mons';

    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_chuyenmon');
    }
}
