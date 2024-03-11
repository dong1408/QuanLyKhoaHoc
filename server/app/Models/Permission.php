<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];


    // relation n-n to roles (1 quyen thuoc ve nhieu vai tro, 1 vai tro co the co nhieu quyen)
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_permission');
    }
}