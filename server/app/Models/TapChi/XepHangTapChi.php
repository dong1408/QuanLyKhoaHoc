<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XepHangTapChi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'xep_hang_tap_chis';
    protected $fillable = [
        'id',
        'id_tapchi',
        'wos',
        'if',
        'quartile',
        'abs',
        'abcd',
        'aci',
        'ghichu',
        'id_user',
        'created_at',
        'updated_at'
    ];

    // relation inverse to tap_chi
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
