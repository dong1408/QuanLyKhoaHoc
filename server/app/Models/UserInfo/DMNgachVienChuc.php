<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMNgachVienChuc extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'd_m_ngach_vien_chucs';

    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_ngachvienchuc');
    }
}
