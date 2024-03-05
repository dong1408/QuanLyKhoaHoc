<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BaiBao\BaiBaoKhoaHocController;
use App\Http\Controllers\Admin\QuyDoi\ChuyenNganhTinhDiemController;
use App\Http\Controllers\Admin\QuyDoi\NganhTinhDiemController;
use App\Http\Controllers\Admin\TapChi\TapChiController;
use App\Http\Controllers\Admin\UserInfo\QuocGiaController;
use App\Http\Controllers\Admin\UserInfo\TinhThanhController;
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

    // BaiBaoKhoaHoc
    Route::get('baibaokhoahoc', [BaiBaoKhoaHocController::class, 'getAll']);

    // TapChi    
    Route::get('test', [TapChiController::class, 'test']);
    Route::get('tapchi', [TapChiController::class, 'getAllTapChi']);
    Route::get('tapchi/paging', [TapChiController::class, 'getTapChiPaging']);
    Route::get('tapchi/{id}', [TapChiController::class, 'getTapChiById']);
    Route::get('tapchi/{id}/khongcongnhan', [TapChiController::class, 'getLichSuTapChiKhongCongNhan']);
    Route::get('tapchi/{id}/xephang', [TapChiController::class, 'getLichSuXepHangTapChi']);
    Route::get('tapchi/{id}/tinhdiem', [TapChiController::class, 'getLichSuTinhDiemTapChi']);
    Route::get('tapchi/{id}/detail', [TapChiController::class, 'getDetailTapChi']);
    Route::get('phanloaitapchi/{id}/tapchi', [TapChiController::class, 'getPhanLoaiTapChiByIdTapChi']);

    Route::post('tapchi', [TapChiController::class, 'createTapChi']);

    Route::patch('tapchi/{id}/trangthai', [TapChiController::class, 'updateTrangThaiTapChi']);
    Route::patch('tapchi/{id}', [TapChiController::class, 'updateTapChi']);
    Route::post('tapchi/{id}/khongcongnhan', [TapChiController::class, 'updateKhongCongNhanTapChi']);
    Route::post('tapchi/{id}/xephang', [TapChiController::class, 'updateXepHangTapChi']);
    Route::post('tapchi/{id}/tinhdiem', [TapChiController::class, 'updateTinhDiemTapChi']);

    Route::delete('tapchi/{id}', [TapChiController::class, 'deleteTapChi']);
    Route::post('tapchi/{id}/restore', [TapChiController::class, 'restoreTapChi']);
    Route::delete('tapchi/{id}/force', [TapChiController::class, 'forceDeleteTapChi']);

    // =============================== UserInfo ============================================== //
    // Quoc Gia
    Route::get('quocgia', [QuocGiaController::class, 'getAllQuocGia']);
    // Tinh Thanh
    Route::get('tinhthanh', [TinhThanhController::class, 'getAllTinhThanh']);


    // ============================== Nganh Tinh Diem ======================================== //
    Route::get('nganhtinhdiem', [NganhTinhDiemController::class, 'getAllNganhTinhDiem']);


    // ============================== Chuyen Nganh Tinh Diem ================================= //
    Route::get('chuyennganhtinhdiem', [ChuyenNganhTinhDiemController::class, 'getAllChuyenNganhTinhDiem']);
});
