<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user() && Auth::user()->changed == 0){
        return view('site.passwordchange');
    }
    return view('trangchu');
})->name('trangchu');

Auth::routes([
    'register' =>false,
    // 'reset' => false,
    'verify' => false,
]);

Route::get('/change-password', [SiteController::class, 'changePassword'])->name('passwordchange')->middleware('checkRole:1;2;9,/');
Route::post('/changePassword',[ResetPasswordController::class, 'changePassword'])->name('changePassword');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
