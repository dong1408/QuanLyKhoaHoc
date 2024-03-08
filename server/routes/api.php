<?php

use App\Http\Controllers\Admin\NhaXuatBan\NhaXuatBanController;
use App\Http\Controllers\Admin\TapChi\NganhTheoHDGSController;
use App\Http\Controllers\Admin\TapChi\PhanLoaiTapChiController;
use App\Http\Controllers\Admin\UserInfo\ToChucController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BaiBao\BaiBaoKhoaHocController;
use App\Http\Controllers\Admin\QuyDoi\ChuyenNganhTinhDiemController;
use App\Http\Controllers\Admin\QuyDoi\NganhTinhDiemController;
use App\Http\Controllers\Admin\SanPham\VaiTroTacGiaController;
use App\Http\Controllers\Admin\TapChi\TapChiController;
use App\Http\Controllers\Admin\UserInfo\QuocGiaController;
use App\Http\Controllers\Admin\UserInfo\TinhThanhController;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\NhaXuatBan\NhaXuatBan;
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
    Route::get('baibao', [BaiBaoKhoaHocController::class, 'getBaiBaoPaging']);
    Route::get('baibaochoduyet', [BaiBaoKhoaHocController::class, 'getBaiBaoChoDuyet']);
    Route::get('baibao/{id}', [BaiBaoKhoaHocController::class, 'getDetailBaiBao']);
    Route::post('baibao', [BaiBaoKhoaHocController::class, 'createBaiBao']);
    Route::patch('baibao/{id}', [BaiBaoKhoaHocController::class, 'updateBaiBao']);
    Route::patch('baibao/{id}/sanpham', [BaiBaoKhoaHocController::class, 'updateSanPham']);
    // Route::patch('baibao/{id}', [BaiBaoKhoaHocController::class, 'updateBaiBao']);
    Route::patch('baibao/{id}/delete', [BaiBaoKhoaHocController::class, 'deleteBaiBao']);
    Route::patch('baibao/{id}/restore', [BaiBaoKhoaHocController::class, 'restoreBaiBao']);
    Route::delete('baibao/{id}/force', [BaiBaoKhoaHocController::class, 'forceDeleteBaiBao']);

    Route::post('baibao/test', [BaiBaoKhoaHocController::class, 'test']);

    // VaiTroTacGia
    Route::get('vaitro/baibao', [VaiTroTacGiaController::class, 'getVaiTroOfBaiBao']);
    Route::get('vaitro/detai', [VaiTroTacGiaController::class, 'getVaiTroOfDeTai']);

    // TapChi
    Route::get('tapchi', [TapChiController::class, 'getAllTapChi']);
    Route::get('tapchi/paging', [TapChiController::class, 'getTapChiPaging']);
    Route::get('tapchi/choduyet/paging', [TapChiController::class, 'getAllTapChiChoDuyet']);
    Route::get('tapchi/{id}', [TapChiController::class, 'getTapChiById']);
    Route::get('tapchi/{id}/khongcongnhan', [TapChiController::class, 'getLichSuTapChiKhongCongNhan']);
    Route::get('tapchi/{id}/xephang', [TapChiController::class, 'getLichSuXepHangTapChi']);
    Route::get('tapchi/{id}/tinhdiem', [TapChiController::class, 'getLichSuTinhDiemTapChi']);
    Route::get('tapchi/{id}/detail', [TapChiController::class, 'getDetailTapChi']);

    Route::post('tapchi', [TapChiController::class, 'createTapChi']);

    Route::patch('tapchi/{id}/trangthai', [TapChiController::class, 'updateTrangThaiTapChi']);
    Route::patch('tapchi/{id}', [TapChiController::class, 'updateTapChi']);
    Route::post('tapchi/{id}/khongcongnhan', [TapChiController::class, 'updateKhongCongNhanTapChi']);
    Route::post('tapchi/{id}/xephang', [TapChiController::class, 'updateXepHangTapChi']);
    Route::post('tapchi/{id}/tinhdiem', [TapChiController::class, 'updateTinhDiemTapChi']);

    Route::patch('tapchi/{id}/delete', [TapChiController::class, 'deleteTapChi']);
    Route::patch('tapchi/{id}/restore', [TapChiController::class, 'restoreTapChi']);
    Route::delete('tapchi/{id}/force', [TapChiController::class, 'forceDeleteTapChi']);

    // =============================== UserInfo ============================================== //
    // Quoc Gia
    Route::get('quocgia', [QuocGiaController::class, 'getAllQuocGia']);
    // Tinh Thanh
    Route::get('tinhthanh', [TinhThanhController::class, 'getAllTinhThanh']);
    Route::get('tinhthanh/{id}/quocgia', [TinhThanhController::class, 'getAllTinhThanhByIdQuocGia']);


    // ============================== Nganh Tinh Diem ======================================== //
    Route::get('nganhtinhdiem', [NganhTinhDiemController::class, 'getAllNganhTinhDiem']);


    // ============================== Chuyen Nganh Tinh Diem ================================= //
    Route::get('chuyennganhtinhdiem', [ChuyenNganhTinhDiemController::class, 'getAllChuyenNganhTinhDiem']);
    Route::get('chuyennganhtinhdiem/{id}/nganhtinhdiem', [ChuyenNganhTinhDiemController::class, 'getChuyeNganhTinhDiemByIdNganhTinhDiem']);

    // ============================== Phan Loai Tap Chi ================================= //
    Route::get('phanloaitapchi/{id}/tapchi', [PhanLoaiTapChiController::class, 'getPhanLoaiTapChiByIdTapChi']);
    Route::get('phanloaitapchi', [PhanLoaiTapChiController::class, 'getAllPhanLoaiTapChi']);

    // ============================== HDGS ================================= //
    Route::get('hdgs', [NganhTheoHDGSController::class, 'getAllHDGS']);

    // ============================== HDGS ================================= //
    Route::get('tochuc', [ToChucController::class, 'getAllToChuc']);

    // ============================== Nha Xuat Ban ================================= //
    Route::get('nhaxuatban', [NhaXuatBanController::class, 'getAllNhaXuatBan']);
});
