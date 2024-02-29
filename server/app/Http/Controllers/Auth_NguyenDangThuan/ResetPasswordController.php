<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("message","Mật khẩu không khớp với hệ thống");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("message","Mật khẩu mới trùng với hiện tại. Vui lòng chọn mật khẩu khác.");
        }

        if(strcmp('dhsg@2021', $request->get('new-password')) == 0){
            //Current password and default password are same
            return redirect()->back()->with("message","Mật khẩu mới trùng với mặc định. Vui lòng chọn mật khẩu khác.");
        }

        $validatedData = $request->validate([
            'email' => 'email|unique:users',
            'current-password' => 'required',
            'new-password' => 'required|case_diff|numbers|letters|symbols|min:6|confirmed', //case_diff dùng để yêu cầu độ khó, cài package shuppo/password-strength
        ]);

        if($validatedData){
            $user = Auth::user();
            if($user->changed == 0){
                if(Auth::user()->email == null){
                    $user->email = $request->input('email');
                }
                $user->changed = 1;
            }
            $user->password = Hash::make($request->get('new-password'));
            /** @var \App\Models\User $user **/
            $user->save();
            return redirect()->back()->with("message","Đổi mật khẩu thành công. Nhấn vào Logo để trở về trang chủ.");
        }else{
            return redirect()->back()->with("message","Đổi mật khẩu không thành công.");
        }
    }
}
