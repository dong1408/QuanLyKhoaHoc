<?php

namespace App\Models\NhaXuatBan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaXuatBan extends Model
{
    use HasFactory;

    // relation 1-n to tap_chi
    public function tapChis()
    {
        return $this->hasMany('App\Models\TapChi\TapChi', 'id_nhaxuatban');
    }
}
