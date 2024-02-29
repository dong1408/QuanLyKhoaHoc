<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $loginPage)
    {
        $user = Auth::user();

        $roleList = explode(';', $role);
        if ($user->changed == 0 || !in_array(''.$user->role, $roleList)) { //không đúng role trong list cho phép hoặc chưa đổi mật khẩu
            return redirect($loginPage);
        }
        
        return $next($request);
    }
}
