<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMNgachVienChuc extends Model
{
    use HasFactory;

    // relation 1-n to user
    public function users()
    {
        return $this->hasMany('App\Models\User', 'id_ngachvienchuc');
    }
}
