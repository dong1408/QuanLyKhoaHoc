<?php

namespace App\Service\Auth;

use Illuminate\Http\Request;
use App\Utilities\ResponseSuccess;


interface AuthService
{
    public function login(Request $request): ResponseSuccess;
    public function register(Request $request): ResponseSuccess;
    public function getMe() : ResponseSuccess;
    public function refreshToken(Request $request) : ResponseSuccess;
    public function logout() : ResponseSuccess;
}
