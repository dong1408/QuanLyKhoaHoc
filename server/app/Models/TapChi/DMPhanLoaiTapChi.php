<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMPhanLoaiTapChi extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'd_m_phan_loai_tap_chi';
    protected $fillable = [
        'id',
        'ma',
        'ten',
        'created_at',
        'updated_at'
    ];


    // relation n-n to tap_chi
    public function tapChis(){
        return $this->belongsToMany('App\Models\TapChi\TapChi');
    }


}
