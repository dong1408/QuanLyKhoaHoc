<?php

namespace App\Models\BaiBao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    protected $table = 'keywords';

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    public function baiBaos()
    {
        return $this->belongsToMany('App\Models\BaiBao\BaiBaoKhoaHoc');
    }
}
