<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Custom\StatusText;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'register']]);
    }


    public function login()
    {
        try {
            $credentials = request(['email', 'password']);
            // Xác thực và tạo access token
            if (!$token = auth('api')->attempt($credentials)) { // thực hiện xác thực với thông tin đăng nhập được cung cấp. Nếu xác thực thành công thì sẽ trả về một token JWT.            
                return response()->json(['error' => 'Người dùng không tồn tại'], 401);
            }
            // Tạo refresh token
            // playload refresh token
            $data = [
                'user_id' => auth('api')->user()->id,
                'exp' => time() + config('jwt.refresh_ttl')
            ];
            // create refresh token
            $refreshToken = JWTAuth::getJWTProvider()->encode($data);
            return $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $e) {
            return response()->json($e);
        }
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required"
        ], [
            "name.required" => "Không được để trống tên đăng nhập",
            "email.required" => "Không được để trống email",
            "email.unique" => "Email đã tồn tại trên hệ thống",
            "password" => "Vui lòng nhập password"
        ]);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        return response()->json($user, 200);
    }


    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }


    protected function profile()
    {
        // $token = Request('');
        try{            
            return response()->json(auth('api')->user(), 200);
        }catch(JWTException $e){
            return response()->json($e->getMessage(), 500);
        }
        // return response()->json(auth('api')->user());
        // $user = auth('api')->user();
        // $rolesOfUser = $user->roles;
        // return response()->json($rolesOfUser);

    }


    public function refresh()
    {
        try {
            $refreshToken = request('refresh_token');
            if(!$refreshToken){
                return response()->json(['message' => 'Refresh token invalid'], 500);
            }
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decode['user_id']);
            if (!$user) {
                return response()->json(['message' => 'Refresh token invalid'], 404);
            }
            // Đưa access token hiện tại vào blacklist            
            // ...
            // Tạo mới access token
            // $accessTokenNew = Auth::refresh(); // Cach nay yeu cau request gui len co ca access token
            $accessNewToken = auth('api')->login($user);            
            return $this->respondWithToken($accessNewToken, $refreshToken);
        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 500);
            // return response()->json(['error' => 'Refresh token invalid'], 500);
        }
    }


    protected function respondWithToken($accessToken, $refreshToken)
    {
        return response()->json([
            'status' => StatusText::_statustext(Response::HTTP_OK),
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ], 200);
    }
}
