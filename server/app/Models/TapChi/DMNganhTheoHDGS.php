<?php

namespace App\Models\TapChi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DMNganhTheoHDGS extends Model
{
    use HasFactory;

    protected $table = 'd_m_nganh_theo_hdgs';
    protected $fillable = [
        'id',
        'ma',
        'ten',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    // relation n-n to tap_chi
    public function tapChis()
    {
        return $this->belongsToMany('App\Models\TapChi\TapChi');
    }
}
