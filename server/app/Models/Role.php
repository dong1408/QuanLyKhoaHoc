<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',   
        'description',
    ];

    // relation n-n to users (1 vai tro thuoc ve nhieu nguoi, 1 nguoi co the co nhieu vai tro)
    public function users(){
        return $this->belongsToMany('App\Models\User', 'user_role');
    }


    // relation n-b to permissions (1 vai tro co nhieu quyen, 1 quyen thuoc ve nhieu vai tro)
    public function permissions(){
        return $this->BelongsToMany('App\Models\Permission', 'role_permission');
    }   
}
