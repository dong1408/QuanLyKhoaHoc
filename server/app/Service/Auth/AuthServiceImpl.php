<?php

namespace App\Service\Auth;

use App\Exceptions\Auth\LoginException;
use App\Models\User;
use App\Utilities\ResponseSuccess;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\TokenInvalid\RefreshTokenInvalid;
use App\ViewModel\Auth\AuthenVm;
use App\ViewModel\User\Me;
use App\Utilities\Convert;

class AuthServiceImpl implements AuthService 
{
    public function login(Request $request): ResponseSuccess
    {
        try {
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            // $accessToken = auth('api')->attempt($credentials);

            // Xác thực và tạo access token
            if (!$accessToken = auth('api')->attempt($credentials)) { // thực hiện xác thực với thông tin đăng nhập được cung cấp. Nếu xác thực thành công thì sẽ trả về một token JWT.            
                throw new LoginException();
            }
            // Tạo refresh token
            // playload refresh token
            $data = [
                'user_id' => auth('api')->user()->id,
                'exp' => time() + config('jwt.refresh_ttl')
            ];
            $refreshToken = JWTAuth::getJWTProvider()->encode($data);
            $authenVm = new AuthenVm($accessToken, $refreshToken);
            return new ResponseSuccess("Đăng nhập thành công", $authenVm);
        } catch (JWTException $e) {
            return response()->json($e);
        }
    }


    public function register(Request $request): ResponseSuccess
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return new ResponseSuccess("Đăng ký thành công", $user);
    }

    public function logout(): ResponseSuccess
    {
        auth('api')->logout();
        return new ResponseSuccess("Đăng xuất thành công", "");
    }

    public function getMe(): ResponseSuccess
    {
        $user = auth('api')->user();
        $me = Convert::getUserVm($user);
        return new ResponseSuccess("Thành công", $me);
    }


    public function refreshToken(Request $request): ResponseSuccess
    {
        $refreshToken = $request->header('RfToken');
        $decode = JWTAuth::getJWTProvider()->decode($refreshToken);
        $user = User::find($decode['user_id']);
        if (!$user) {
            throw new RefreshTokenInvalid();
        }
        // Đưa access token hiện tại vào blacklist            
        // ...
        // Tạo mới access token
        $accessNewToken = auth('api')->login($user);
        $authenVm = new AuthenVm($accessNewToken, $refreshToken);
        return new ResponseSuccess("Thành công", $authenVm);
    }
}
