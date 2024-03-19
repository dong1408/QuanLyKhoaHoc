<?php

use App\Http\Controllers\Admin\NhaXuatBan\NhaXuatBanController;
use App\Http\Controllers\Admin\TapChi\NganhTheoHDGSController;
use App\Http\Controllers\Admin\TapChi\PhanLoaiTapChiController;
use App\Http\Controllers\Admin\UserInfo\ToChucController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BaiBao\BaiBaoKhoaHocController;
use App\Http\Controllers\Admin\DeTai\DeTaiController;
use App\Http\Controllers\Admin\DeTai\PhanLoaiDeTaiController;
use App\Http\Controllers\Admin\QuyDoi\ChuyenNganhTinhDiemController;
use App\Http\Controllers\Admin\QuyDoi\NganhTinhDiemController;
use App\Http\Controllers\Admin\RolePermission\PermissionController;
use App\Http\Controllers\Admin\RolePermission\RoleController;
use App\Http\Controllers\Admin\SanPham\DMSanPhamController;
use App\Http\Controllers\Admin\SanPham\VaiTroTacGiaController;
use App\Http\Controllers\Admin\TapChi\TapChiController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\UserInfo\ChuyenMonController;
use App\Http\Controllers\Admin\UserInfo\DonViController;
use App\Http\Controllers\Admin\UserInfo\HocHamHocViController;
use App\Http\Controllers\Admin\UserInfo\NgachVienChucController;
use App\Http\Controllers\Admin\UserInfo\PhanLoaiToChucController;
use App\Http\Controllers\Admin\UserInfo\QuocGiaController;
use App\Http\Controllers\Admin\UserInfo\TinhThanhController;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\NhaXuatBan\NhaXuatBan;
use App\Models\User;
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
//    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refreshToken', [AuthController::class, 'refreshToken']);
    Route::get('auth/getMe', [AuthController::class, 'getMe']);

    // User
    Route::get('users', [UserController::class, 'getAllUser']); //select chọn tác giả
    Route::get('users/info', [UserController::class, 'getUserInfo']); 
    Route::get('users/paging', [UserController::class, 'getUserPaging'])->can('user.view');
    Route::get('users/{id}/role', [UserController::class, 'getRoleOfUser'])->can('user.update_role');
//    Route::get('users/permission', [UserController::class, 'getPermissionOfUser'])->can('user.detail');
    Route::patch('users/password', [UserController::class, 'changePassword']);
    Route::post('users', [UserController::class, 'registerUser'])->can('user.register');
    Route::patch('users/{id}', [UserController::class, 'updateUser'])->can('user.update'); // admin + owner
    Route::patch('users/{id}/role', [UserController::class, 'updateRoleOfUser'])->can('user.update_role');
    Route::patch('users/{id}/delete', [UserController::class, 'deleteUser'])->can('user.delete');
    Route::patch('users/{id}/restore', [UserController::class, 'restoreUser'])->can('user.delete');
    Route::delete('users/{id}/force', [UserController::class, 'forceDeleteUser'])->can('user.delete');
    Route::get('users/{id}', [UserController::class, 'getUserDetail'])->can('user.update'); // dùng cho admin

    // Role
    Route::get('roles', [RoleController::class, 'getAllRole'])->can("role.view");
    Route::get('roles/{id}', [RoleController::class, 'getPermissionsOfRole'])->can('role.view');
    Route::post('roles', [RoleController::class, 'addRole'])->can('role.add');
    Route::patch('roles/{id}', [RoleController::class, 'updateRole'])->can('role.update');


    // Permission
    Route::get('permissions', [PermissionController::class, 'getAllPermission'])->can('role.view');
    Route::post('permissions', [PermissionController::class, 'addPermission'])->can('role.add');
    Route::patch('permissions/{id}', [PermissionController::class, 'updatePermission'])->can('role.update');



    // BaiBaoKhoaHocs
    Route::get('baibao/public', [BaiBaoKhoaHocController::class, 'getBaiBaoPagingForUser']);
    Route::get('baibao/public/{id}', [BaiBaoKhoaHocController::class, 'getDetailBaiBaoForUser']);

    Route::get('baibao', [BaiBaoKhoaHocController::class, 'getBaiBaoPaging'])->can('baibao.view'); // canview
    Route::get('baibao/choduyet', [BaiBaoKhoaHocController::class, 'getBaiBaoChoDuyet'])->can('baibao.view'); // canview
    Route::post('baibao', [BaiBaoKhoaHocController::class, 'createBaiBao'])->can('baibao.add');
    Route::patch('baibao/{id}/sanpham', [BaiBaoKhoaHocController::class, 'updateSanPham'])->can('baibao.update'); // admin + owner
    Route::patch('baibao/{id}', [BaiBaoKhoaHocController::class, 'updateBaiBao'])->can('baibao.update'); // admin + owner
    Route::patch('baibao/{id}/sanphamtacgia', [BaiBaoKhoaHocController::class, 'updateSanPhamTacGia'])->can('baibao.update'); // admin + owner
    Route::patch('baibao/{id}/fileminhchung', [BaiBaoKhoaHocController::class, 'updateFileMinhChung'])->can('baibao.update'); // admin + owner
    Route::patch('baibao/{id}/trangthairasoat', [BaiBaoKhoaHocController::class, 'updateTrangThaiRaSoatBaiBao'])->can('baibao.status');
    Route::patch('baibao/{id}/delete', [BaiBaoKhoaHocController::class, 'deleteBaiBao'])->can('baibao.delete');
    Route::patch('baibao/{id}/restore', [BaiBaoKhoaHocController::class, 'restoreBaiBao'])->can('baibao.delete');
    Route::delete('baibao/{id}/force', [BaiBaoKhoaHocController::class, 'forceDeleteBaiBao'])->can('baibao.delete');

    Route::get('baibao/kekhai', [BaiBaoKhoaHocController::class, 'getBaiBaoKeKhai']);
    Route::get('baibao/thamgia', [BaiBaoKhoaHocController::class, 'getBaiBaoThamGia']);
    Route::get('baibao/{id}', [BaiBaoKhoaHocController::class, 'getDetailBaiBao'])->can('baibao.view'); // admin + owner canview



    // DeTai
    Route::get('detai/public', [DeTaiController::class, 'getDeTaiPagingForUser']);
    Route::get('detai/public/{id}', [DeTaiController::class, 'getDetailDeTaiForUser']);


    Route::get('detai', [DeTaiController::class, 'getDeTaiPaging'])->can('detai.view');
    Route::get('detai/choduyet', [DeTaiController::class, 'getDeTaiChoDuyet'])->can('detai.view');
    Route::post('detai', [DeTaiController::class, 'createDetai'])->can('detai.add');
    Route::patch('detai/{id}/sanpham', [DeTaiController::class, 'updateSanPham'])->can('detai.update');// admin + owner
    Route::patch('detai/{id}', [DeTaiController::class, 'updateDeTai'])->can('detai.update');// admin + owner
    Route::patch('detai/{id}/sanphamtacgia', [DeTaiController::class, 'updateSanPhamTacGia'])->can('detai.update'); // admin + owner
    Route::patch('detai/{id}/fileminhchung', [DeTaiController::class, 'updateFileMinhChung'])->can('detai.update'); // admin + owner
    Route::patch('detai/{id}/trangthairasoat', [DeTaiController::class, 'updateTrangThaiRaSoatDeTai'])->can('detai.status');
    Route::post('detai/{id}/tuyenchon', [DeTaiController::class, 'tuyenChonDeTai'])->can('detai.status');
    Route::post('detai/{id}/xetduyet', [DeTaiController::class, 'xetDuyetDeTai'])->can('detai.status');
    Route::post('detai/{id}/baocao', [DeTaiController::class, 'baoCaoTienDoDeTai'])->can('detai.status');
    Route::post('detai/{id}/nghiemthu', [DeTaiController::class, 'nghiemThuDeTai'])->can('detai.status');
    Route::get('detai/{id}/lichsubaocao', [DeTaiController::class, 'getLichSuBaoCao'])->can('detai.status');
    Route::patch('detai/{id}/delete', [DeTaiController::class, 'deleteDeTai'])->can('detai.delete');
    Route::patch('detai/{id}/restore', [DeTaiController::class, 'restoreDeTai'])->can('detai.delete');
    Route::delete('detai/{id}/forceDelete', [DeTaiController::class, 'forceDeleteDeTai'])->can('detai.delete');
    Route::get('detai/kekhai', [DeTaiController::class, 'getDeTaiKeKhai']);
    Route::get('detai/thamgia', [DeTaiController::class, 'getDeTaiThamGia']);
    Route::get('detai/{id}', [DeTaiController::class, 'getDetailDeTai'])->can('detai.view'); // cho admin + owner

    // PhanLoaiDeTai
    Route::get('phanloaidetai', [PhanLoaiDeTaiController::class, 'getPhanLoaiDeTai']);


    // SanPham
    Route::get('dmsanpham', [DMSanPhamController::class, 'getDmSanPham']);


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

    // To Chuc
    Route::get('tochuc', [ToChucController::class, 'getAllToChuc']);

    // Chuyen Mon
    Route::get('chuyenmon', [ChuyenMonController::class, 'getAllChuyenMon']);

    // Don Vi
    Route::get('donvi', [DonViController::class, 'getAllDonVi']);
    Route::get('donvi/{id}/tochuc', [DonViController::class, 'getDonViByToChucId']);

    // Hoc Ham Hoc Vi
    Route::get('hochamhocvi', [HocHamHocViController::class, 'getAllHocHamHocVi']);

    // Ngach Vien Chuc
    Route::get('ngachvienchuc', [NgachVienChucController::class, 'getAllNgachVienChuc']);

    // Phan Loai To Chuc
    Route::get('phanloaitochuc', [PhanLoaiToChucController::class, 'getAllPhanLoaiToChuc']);



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
