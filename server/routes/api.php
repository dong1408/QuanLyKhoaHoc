<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BaiBao\BaiBaoKhoaHocController;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'api'
], function ($router) {

    // Auth
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refreshToken', [AuthController::class, 'refreshToken']);
    Route::get('auth/getMe', [AuthController::class, 'getMe']);

    // Admin-BaiBaoKhoaHoc
    Route::get('baibaokhoahoc', [BaiBaoKhoaHocController::class, 'getAll']);
});
