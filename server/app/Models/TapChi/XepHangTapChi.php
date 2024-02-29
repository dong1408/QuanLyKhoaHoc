<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XepHangTapChi extends Model
{
    use HasFactory;

    // relation 1-1, inverse to tap_chi
    public function tapChi()
    {
        return $this->belongsTo('App\Models\TapChi\TapChi', 'id_tapchi');
    }

    // inver to user
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
