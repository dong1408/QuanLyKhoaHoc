<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\Auth\AuthService;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login', 'refreshToken', 'register']]);
    }


    
    public function login(Request $request): Response
    {
        $result = $this->authService->login();
        return response()->json($result, 200);
    }


    public function register(Request $request): Response
    {
        $result = $this->authService->register($request);
        return response()->json($result, 200);
    }


    public function logout(): Response
    {
        $result = $this->authService->logout();
        return response()->json($result, 200);
    }


    protected function getMe(): Response
    {
        $result = $this->authService->getMe();
        return response()->json($result, 200);
    }


    public function refreshToken(Request $request): Response
    {
        $result = $this->authService->refreshToken($request);
        return response()->json($result, 200);
    }

}
