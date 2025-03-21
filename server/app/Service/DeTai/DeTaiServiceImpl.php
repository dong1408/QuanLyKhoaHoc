<?php

namespace App\Service\DeTai;

use App\Exceptions\BaiBao\VaiTroOfBaiBaoException;
use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\DeTai\ChuDeTaiException;
use App\Exceptions\DeTai\CreateDeTaiFailedException;
use App\Exceptions\DeTai\DeTaiCanNotBaoCaoException;
use App\Exceptions\DeTai\DeTaiCanNotNghiemThuException;
use App\Exceptions\DeTai\DeTaiCanNotTuyenChonException;
use App\Exceptions\DeTai\DeTaiCanNotUpdateException;
use App\Exceptions\DeTai\DeTaiCanNotXetDuyetException;
use App\Exceptions\DeTai\DeTaiNotFoundException;
use App\Exceptions\DeTai\DeTaiNotHaveChuNhiemException;
use App\Exceptions\DeTai\DeTaiNotXacNhanException;
use App\Exceptions\DeTai\KetQuaTuyenChonDeTaiException;
use App\Exceptions\DeTai\KetQuaXetDuyetDeTaiException;
use App\Exceptions\DeTai\PermissionUpdateTacGiaDeTaiException;
use App\Exceptions\DeTai\RoleOnlyHeldByOnePersonInDeTaiException;
use App\Exceptions\DeTai\TwoRoleSimilarForOnePersonInDeTaiException;
use App\Exceptions\DeTai\VaiTroOfDeTaiException;
use App\Exceptions\InvalidValueException;
use App\Exceptions\SanPham\FileMinhChungNotFoundException;
use App\Exceptions\SanPham\LoaiSanPhamWrongException;
use App\Exceptions\SanPham\UpdateTrangThaiRaSoatException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotHavePermissionException;
use App\Http\Requests\DeTai\BaoCaoTienDoDeTaiRequest;
use App\Http\Requests\DeTai\CreateDeTaiRequest;
use App\Http\Requests\DeTai\NghiemThuDeTaiRequest;
use App\Http\Requests\DeTai\TuyenChonDeTaiRequest;
use App\Http\Requests\DeTai\UpdateDeTaiForUserRequest;
use App\Http\Requests\DeTai\UpdateDeTaiRequest;
use App\Http\Requests\DeTai\XetDuyetDeTaiRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Http\Requests\SanPham\UploadFileMinhChungRequest;
use App\Models\DeTai\BaoCaoTienDo;
use App\Models\DeTai\DeTai;
use App\Models\DeTai\NghiemThu;
use App\Models\DeTai\TuyenChon;
use App\Models\DeTai\XetDuyet;
use App\Models\FileMinhChungSanPham;
use App\Models\Role;
use App\Models\SanPham\DMSanPham;
use App\Models\SanPham\DMVaiTroTacGia;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\User;
use App\Models\UserInfo\DMToChuc;
use App\Service\DeTai\DeTaiService;
use App\Service\GoogleDrive\GoogleDriveService;
use App\Service\User\UserService;
use App\Service\UserInfo\ToChucService;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeTaiServiceImpl implements DeTaiService
{

    private UserService $userService;
    private ToChucService $toChucService;
    private GoogleDriveService $googleDriveService;

    public function __construct(UserService $userService, ToChucService $toChucService, GoogleDriveService $googleDriveService)
    {
        $this->userService = $userService;
        $this->toChucService = $toChucService;
        $this->googleDriveService = $googleDriveService;
    }


    public function getDeTaiPaging(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $isLock = $request->query('isLock', 0);
        $filter = $request->query('filter', "all");
        $sanPhams = null;
        if ($isLock == 1) {  // Lấy những đề tài bị xóa mềm
            if ($filter == "cho_tuyen_chon") {
                $sanPhams = SanPham::onlyTrashed()
                    ->doesntHave('tuyenChon')->doesntHave('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "tuyen_chon_that_bai") {
                $sanPhams = SanPham::onlyTrashed()
                    ->has('tuyenChon')->doesntHave('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('tuyen_chons', 'tuyen_chons.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where('tuyen_chons.ketquatuyenchon', '=', 'Không đủ điều kiện')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "cho_xet_duyet") {
                $sanPhams = SanPham::onlyTrashed()
                    ->has('tuyenChon')->doesntHave('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('tuyen_chons', 'tuyen_chons.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where('tuyen_chons.ketquatuyenchon', '=', 'Đủ điều kiện')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "xet_duyet_that_bai") {
                $sanPhams = SanPham::onlyTrashed()
                    ->has('tuyenChon')->has('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('xet_duyets', 'xet_duyets.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('xet_duyets.ketquaxetduyet', '=', 'Không đủ điều kiện')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "cho_nghiem_thu") {
                $sanPhams = SanPham::onlyTrashed()
                    ->has('tuyenChon')->has('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('xet_duyets', 'xet_duyets.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('xet_duyets.ketquaxetduyet', '=', 'Đủ điều kiện')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "nghiem_thu") {
                $sanPhams = SanPham::onlyTrashed()
                    ->has('tuyenChon')->has('xetDuyet')->has('nghiemThu')
                    ->select('san_phams.*')
                    ->join('nghiem_thus', 'nghiem_thus.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } else {
                $sanPhams = SanPham::onlyTrashed()->select('san_phams.*')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            }
        } else { // Lấy những bản ghi not softdelete 
            if ($filter == "cho_tuyen_chon") { // tuyen chon -> chờ xét duyệt (tuyenchon -> true)(đã tuyển chọn thành công) -> da xet duyet -> nghiem thu
                $sanPhams = SanPham::doesntHave('tuyenChon')->doesntHave('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "tuyen_chon_that_bai") {
                $sanPhams = SanPham::has('tuyenChon')->doesntHave('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('tuyen_chons', 'tuyen_chons.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where('tuyen_chons.ketquatuyenchon', '=', 'Không đủ điều kiện')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "cho_xet_duyet") {
                $sanPhams = SanPham::has('tuyenChon')->doesntHave('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('tuyen_chons', 'tuyen_chons.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where('tuyen_chons.ketquatuyenchon', '=', 'Đủ điều kiện')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "xet_duyet_that_bai") {
                $sanPhams = SanPham::has('tuyenChon')->has('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('xet_duyets', 'xet_duyets.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('xet_duyets.ketquaxetduyet', '=', 'Không đủ điều kiện')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "cho_nghiem_thu") {
                $sanPhams = SanPham::has('tuyenChon')->has('xetDuyet')->doesntHave('nghiemThu')
                    ->select('san_phams.*')
                    ->join('xet_duyets', 'xet_duyets.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('xet_duyets.ketquaxetduyet', '=', 'Đủ điều kiện')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } elseif ($filter == "nghiem_thu") {
                $sanPhams = SanPham::has('tuyenChon')->has('xetDuyet')->has('nghiemThu')
                    ->select('san_phams.*')
                    ->join('nghiem_thus', 'nghiem_thus.id_sanpham', '=', 'san_phams.id')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            } else {
                $sanPhams = SanPham::select('san_phams.*')
                    ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                    ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                    ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                    ->where('d_m_san_phams.masanpham', '=', 'detai')
                    ->where(function ($query) use ($keysearch) {
                        $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                            ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                    })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                    ->groupBy('san_phams.id')
                    ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
            }
        }
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getDeTaiVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getDeTaiPagingForUser(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::has('tuyenChon')->has('xetDuyet')->has('nghiemThu')
            ->select('san_phams.*')
            ->join('nghiem_thus', 'nghiem_thus.id_sanpham', '=', 'san_phams.id')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
            ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
            ->where('d_m_san_phams.masanpham', '=', 'detai')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
            })->where('san_phams.trangthairasoat', 'Đã xác nhận')
            ->groupBy('san_phams.id')
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getDeTaiVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getDeTaiChoDuyet(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
            ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
            ->where('d_m_san_phams.masanpham', '=', 'detai')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
            })->where('san_phams.trangthairasoat', 'Đang rà soát')
            ->groupBy('san_phams.id')
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getDeTaiVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }

    public function getDetailDeTai(int $id): ResponseSuccess
    {
        $id_sanpham = $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null || $sanPham->dmSanPham->masanpham != "detai") {
            throw new DeTaiNotFoundException();
        }
        $result = Convert::getDeTaiDetailVm($sanPham);
        return new ResponseSuccess("Thành công", $result);
    }


    public function getDetailDeTaiForUser(int $id): ResponseSuccess
    {
        $id_sanpham = $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()
            ->has('tuyenChon')->has('xetDuyet')->has('nghiemThu')
            ->find($id_sanpham);
        if ($sanPham == null || $sanPham->dmSanPham->masanpham != "detai") {
            throw new DeTaiNotFoundException();
        }

        if ($sanPham->trangthairasoat == "Đang rà soát") {
            throw new DeTaiNotFoundException();
        }

        $result = Convert::getDeTaiDetailVm($sanPham);
        $result->trangthairasoat = null;
        $result->sanpham->ngayrasoat = null;
        $result->sanpham->nguoirasoat = null;
        $result->nghiemthu = null;
        $result->xetduyet = null;
        $result->tuyenchon = null;

        return new ResponseSuccess("Thành công", $result);
    }

    public function createDeTai(CreateDeTaiRequest $request): ResponseSuccess
    {
        $validated = $request->validated();

        $deTai = new DeTai();
        $sanPham = new SanPham();

        DB::transaction(function () use ($validated, &$deTai, &$sanPham, &$request) {
            $listIdTacGia = [];
            $listIdVaiTro = [];
            $thuTus = [];
            $tyLeDongGops = [];
            $listSanPhamTacGia = $validated['sanpham_tacgia'];

            $donVi = !empty($validated['sanpham']['donvi']) ? $validated['sanpham']['donvi'] : null;
            $toChucChuQuan = !empty($validated['tochucchuquan']) ? $validated['tochucchuquan'] : null;
            $toChucHopTac = !empty($validated['tochuchoptac']) ? $validated['tochuchoptac'] : null;

            // Lọc ra những sanphamtacgia có id_tacgia = nul
            $filteredWithoutIdTacGia = array_filter($listSanPhamTacGia, function ($object) {
                return is_null($object['id_tacgia']);
            });


            // Lọc ra những to chuc tác giả có id_tacgia != nul
            $filteredWithoutIdToChuc = array_filter($listSanPhamTacGia, function ($object) {
                if (!is_null($object['tochuc'])) {
                    return is_null($object['tochuc']['id_tochuc']);
                }
            });



            // check có nhận tài trợ và đơn vị tài trợ ngoài thì thêm mới vào hệ thống
            if ($donVi != null) {
                if ($validated['sanpham']['donvi']['id_donvi'] == null && $validated['sanpham']['conhantaitro']) {
                    $validated['sanpham']['donvi']['id_donvi'] = $this->keKhaiDonVi($validated['sanpham']['donvi']);
                }
            }

            // check đề tài ngoài trường và tổ chức chủ quản ngoài thì thêm mới vào hệ thống
            if ($toChucChuQuan != null) {
                if ($validated['tochucchuquan']['id_tochucchuquan'] == null && $validated['ngoaitruong']) {
                    $validated['tochucchuquan']['id_tochucchuquan'] = $this->keKhaiToChucChuQuan($validated['tochucchuquan']);
                }
            }



            // check đề tài có phải đề tài hợp tác và tổ chức hơp tác ngoài thì thêm mới vào hệ thống
            if ($toChucHopTac) {
                if ($validated['tochuchoptac']['id_tochuchoptac'] == null && $validated['detaihoptac']) {
                    $validated['tochuchoptac']['id_tochuchoptac'] = $this->keKhaiToChucHopTac($validated['tochuchoptac']);
                }
            }


            // check những tác giả ngoài thì thêm vào hệ thống
            if (count($filteredWithoutIdTacGia) > 0) {
                $listSanPhamTacGia = $this->keKhaiTacGia($listSanPhamTacGia);
            }


            // check những tổ chức ngoài thì thêm vào hệ thống
            if (count($filteredWithoutIdToChuc) > 0) {
                $listSanPhamTacGia = $this->keKhaiToChuc($listSanPhamTacGia);
            }
            //            // add tổ chức cho tác giả
            foreach ($listSanPhamTacGia as $sanPhamTacGia) {
                $user = User::find($sanPhamTacGia['id_tacgia']);
                if ($user == null) {
                    $this->googleDriveService->deleteFile($validated['fileminhchungsanpham']['id_file']);
                    throw new UserNotFoundException();
                }
                if ($sanPhamTacGia['tochuc'] && $sanPhamTacGia['tochuc']['id_tochuc']) {
                    $user->id_tochuc = $sanPhamTacGia['tochuc']['id_tochuc'];
                    $user->save();
                }
            }


            // Kiểm tra các vai trò tác giả phải là vai trò tác giả của đề tài 
            foreach ($listSanPhamTacGia as $sanPhamTacGia) {
                foreach ($sanPhamTacGia['list_id_vaitro'] as $idvaitro) {
                    if (DMVaiTroTacGia::where([['role', '=', 'detai'], ['id', '=', $idvaitro]])->first() == null) {
                        $this->googleDriveService->deleteFile($validated['fileminhchungsanpham']['id_file']);
                        throw new VaiTroOfBaiBaoException();
                    }
                    $listIdTacGia[] = $sanPhamTacGia['id_tacgia'];
                    $listIdVaiTro[] = $idvaitro;
                    $thuTus[] = $sanPhamTacGia['thutu'];
                    $tyLeDongGops[] = $sanPhamTacGia['tyledonggop'];
                }
            }


            $vaiTros = DMVaiTroTacGia::whereIn('id', $listIdVaiTro)->get();

            // Kiểm tra đề tài phải có chủ nhiệm
            $flag = false;
            foreach ($vaiTros as $vaiTro) {
                if ($vaiTro->mavaitro == 'chunhiem') {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                $this->googleDriveService->deleteFile($validated['fileminhchungsanpham']['id_file']);
                throw new DeTaiNotHaveChuNhiemException();
            }

            // kiểm tra 1 người có 2 vai trò giống nhau trong đề tài
            for ($i = 0; $i < count($listIdTacGia) - 1; $i++) {
                for ($z = $i + 1; $z < count($listIdVaiTro); $z++) {
                    if (($listIdTacGia[$i] == $listIdTacGia[$z]) && ($listIdVaiTro[$i] == $listIdVaiTro[$z])) {
                        $this->googleDriveService->deleteFile($validated['fileminhchungsanpham']['id_file']);
                        throw new TwoRoleSimilarForOnePersonInDeTaiException();
                    }
                }
            }

            // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
            $allVaiTroDB = DMVaiTroTacGia::all();
            foreach ($allVaiTroDB as $vaitro) {
                if ($vaitro->mavaitro == 'chunhiem') {
                    $idVaiTroChuNhiem = $vaitro->id;
                }
            }
            if (isset(array_count_values($listIdVaiTro)[$idVaiTroChuNhiem]) && array_count_values($listIdVaiTro)[$idVaiTroChuNhiem] >= 2) {
                $this->googleDriveService->deleteFile($validated['fileminhchungsanpham']['id_file']);
                throw new RoleOnlyHeldByOnePersonInDeTaiException();
            }

            $dmSanPhamDeTai = DMSanPham::where('masanpham', 'detai')->first();
            if ($dmSanPhamDeTai == null) {
                $this->googleDriveService->deleteFile($validated['fileminhchungsanpham']['id_file']);
                throw new CreateDeTaiFailedException();
            }

            // Thực hiên insert khi không còn lỗi
            $sanPham = SanPham::create([
                'tensanpham' => $validated['sanpham']['tensanpham'],
                'id_loaisanpham' => $dmSanPhamDeTai->id,
                'tongsotacgia' => $validated['sanpham']['tongsotacgia'],
                'conhantaitro' => $validated['sanpham']['conhantaitro'],
                'id_donvitaitro' => $validated['sanpham']['conhantaitro'] == true && !empty($validated['sanpham']['donvi']['id_donvi']) ? $validated['sanpham']['donvi']['id_donvi'] : null,
                'chitietdonvitaitro' => $validated['sanpham']['conhantaitro'] == true ? $validated['sanpham']['chitietdonvitaitro'] : null,
                'ngaykekhai' => date("Y-m-d"),
                'id_nguoikekhai' => auth('api')->user()->id,
                'trangthairasoat' => "Đang rà soát",
            ]);

            $deTai = DeTai::create([
                'id_sanpham' => $sanPham->id,
                'maso' => $validated['maso'],
                "ngaydangky" => date("Y-m-d"),
                'ngoaitruong' => $validated['ngoaitruong'],
                'truongchutri' => $validated['ngoaitruong'] == true ?  $validated['truongchutri'] : null,
                'id_tochucchuquan' => $validated['ngoaitruong'] == true && !empty($validated['tochucchuquan']['id_tochucchuquan']) ? $validated['tochucchuquan']['id_tochucchuquan'] : null,
                'id_loaidetai' => $validated['ngoaitruong'] == false ? $validated['id_loaidetai'] : null,
                'detaihoptac' => $validated['detaihoptac'],
                'id_tochuchoptac' => $validated['detaihoptac'] == true && !empty($validated['tochuchoptac']['id_tochuchoptac']) ? $validated['tochuchoptac']['id_tochuchoptac'] : null,
                'tylekinhphidonvihoptac' => $validated['detaihoptac'] == true ?  $validated['tylekinhphidonvihoptac'] : null,
                'capdetai' => $validated['capdetai'],
            ]);



            FileMinhChungSanPham::create([
                'id_sanpham' => $sanPham->id,
                'url' => $validated['fileminhchungsanpham']['file'],
            ]);

            for ($i = 0; $i < count($listIdTacGia); $i++) {
                $tacGiaId = $listIdTacGia[$i];
                $vaiTroId = $listIdVaiTro[$i];
                $thuTu = isset($thuTus[$i]) ? $thuTus[$i] : null;
                $tyLeDongGop = isset($tyLeDongGops[$i]) ? $tyLeDongGops[$i] : null;

                SanPhamTacGia::create([
                    'id_sanpham' => $sanPham->id,
                    'id_tacgia' => $tacGiaId,
                    'id_vaitrotacgia' => $vaiTroId,
                    'thutu' => $thuTu,
                    'tyledonggop' => $tyLeDongGop
                ]);
            }
        });

        $result = Convert::getDeTaiVm($sanPham);
        return new ResponseSuccess("Đăng ký đề tài thành công", $result);
    }


    private function keKhaiTacGia($listSanPhamTacGia)
    {
        if (is_array($listSanPhamTacGia)) {

            // Lọc ra những tác giả cần thêm vào hệ thống (những id_tacgia = null)
            $tacGiaMois = array_filter($listSanPhamTacGia, function ($object) {
                return is_null($object['id_tacgia']);
            });

            // Lọc ra những tác giả kh cần kê khai
            $tacGiaOlds = array_filter($listSanPhamTacGia, function ($object) {
                return !is_null($object['id_tacgia']);
            });

            // Lọc ra những tác giả kê khai giống nhau (giống email)  thì thông báo lỗi
            // $listTacGiaSame = $this->filterUniqueAndDuplicates($tacGiaMois, 'email');
            // if (count($listTacGiaSame) > 0) {
            // }

            $idRoleGuest = Role::where('mavaitro', 'guest')->first()->id;
            foreach ($tacGiaMois as $key => $item) {
                $userFind = User::where('email', $item['email'])->get()->first();
                if ($userFind == null) {
                    $randomId = $this->randomUnique();
                    $array = [
                        'username' => env('SGU_2024') . $randomId,
                        'password' => Hash::make(env('SGU_2024')),
                        'name' => $item['tentacgia'],
                        'ngaysinh' => $item['ngaysinh'],
                        'dienthoai' => $item['dienthoai'],
                        'email' => $item['email'],
                        'id_hochamhocvi' => $item['id_hochamhocvi']
                    ];
                    $user = $this->userService->themTacGiaNgoai($array);
                    $user->roles()->attach($idRoleGuest);
                    $tacGiaMois[$key]['id_tacgia'] = $user->id;
                } else {
                    $tacGiaMois[$key]['id_tacgia'] = $userFind->id;
                }
            }

            $listSanPhamTacGia = array_merge($tacGiaMois, $tacGiaOlds);
        }
        return $listSanPhamTacGia;
    }



    private function keKhaiToChuc($listSanPhamTacGia)
    {
        if (is_array($listSanPhamTacGia)) {
            // Lọc ra những sanphamtacgia co tổ chức cần thêm vào hệ thống
            $sanphamtacgiasWithIdTochucNull = array_filter($listSanPhamTacGia, function ($object) {
                if (isset($object['tochuc']) && is_null($object['tochuc']['id_tochuc'])) {
                    return $object;
                }
                //return is_null($object['tochuc']['id_tochuc']);
            });

            // Lojc ra những sanphamtacgia có những tổ chức không cần thêm (id_tochuc != null)
            $sanphamtacgiasWithIdTochucNotNull = array_filter($listSanPhamTacGia, function ($object) {
                if (isset($object['tochuc']) && !is_null($object['tochuc']['id_tochuc'])) {
                    return $object;
                }
                if (is_null($object['tochuc'])) {
                    return $object;
                }
                //                return !is_null($object['id_tacgia']) &&  !is_null($object['tochuc']) && !is_null($object['tochuc']['id_tochuc']);
                //return !is_null($object['tochuc']['id_tochuc']);
            });



            foreach ($sanphamtacgiasWithIdTochucNull as $key => $item) {
                $toChucFind = DMToChuc::where('tentochuc', $item['tochuc']['tentochuc'])->get()->first();
                if ($toChucFind == null) {
                    $array = [
                        'tentochuc' => $item['tochuc']['tentochuc'],
                    ];
                    $toChuc = $this->toChucService->themToChucNgoai($array);
                    $sanphamtacgiasWithIdTochucNull[$key]['tochuc']['id_tochuc'] = $toChuc->id;
                } else {
                    $sanphamtacgiasWithIdTochucNull[$key]['tochuc']['id_tochuc'] = $toChucFind->id;
                }
            }

            $listSanPhamTacGia = array_merge($sanphamtacgiasWithIdTochucNull, $sanphamtacgiasWithIdTochucNotNull);
        }
        return $listSanPhamTacGia;
    }





    private function keKhaiDonVi($donVi)
    {
        $donViFind = DMToChuc::where('tentochuc', $donVi['tentochuc'])->get()->first();
        if ($donViFind == null) {
            $array = [
//                'matochuc' => $donVi['matochuc'],
                'tentochuc' => $donVi['tentochuc'],
            ];
            $donViTaiTro = $this->toChucService->themToChucNgoai($array);
            return $donViTaiTro->id;
        }
        return $donViFind->id;
    }

    private function keKhaiToChucChuQuan($toChucChuQuan)
    {
        $toChucChuQuanFind = DMToChuc::where('tentochuc', $toChucChuQuan['tentochuc'])->get()->first();
        if ($toChucChuQuanFind == null) {
            $array = [
                'tentochuc' => $toChucChuQuan['tentochuc'],
            ];
            $toChucChuQuanMd = $this->toChucService->themToChucNgoai($array);
            return $toChucChuQuanMd->id;
        }
        return $toChucChuQuanFind->id;
    }


    private function keKhaiToChucHopTac($toChucHopTac)
    {
        $toChucHopTacFind = DMToChuc::where('tentochuc', $toChucHopTac['tentochuc'])->get()->first();
        if ($toChucHopTacFind == null) {
            $array = [
                'tentochuc' => $toChucHopTac['tentochuc'],
            ];
            $toChucHopTacMd = $this->toChucService->themToChucNgoai($array);
            return $toChucHopTacMd->id;
        }
        return $toChucHopTacFind->id;
    }



    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;

        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }

        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }

        // check đề tài đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('detai.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }


        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        $validated = $request->validated();

        $sanPham->tensanpham = $validated['tensanpham'];
        //        $sanPham->id_loaisanpham = $validated['id_loaisanpham'];
        //        $sanPham->tongsotacgia = $validated['tongsotacgia'];
        $sanPham->solandaquydoi = $validated['solandaquydoi'];
        $sanPham->cosudungemailtruong = $validated['cosudungemailtruong'];
        $sanPham->cosudungemaildonvikhac = $validated['cosudungemaildonvikhac'];
        $sanPham->cothongtintruong = $validated['cothongtintruong'];
        $sanPham->cothongtindonvikhac =  $validated['cothongtindonvikhac'];
        $sanPham->id_thongtinnoikhac =  $validated['cothongtindonvikhac'] == true ? $validated['id_thongtinnoikhac'] : null;
        $sanPham->conhantaitro = $validated['conhantaitro'];
        $sanPham->id_donvitaitro = $validated['conhantaitro'] == true ? $validated['id_donvitaitro'] : null;
        $sanPham->chitietdonvitaitro = $validated['conhantaitro'] == true ? $validated['chitietdonvitaitro'] : null;
        $sanPham->ngaykekhai = $validated['ngaykekhai'];
        $sanPham->diemquydoi = $validated['diemquydoi'];
        $sanPham->gioquydoi = $validated['gioquydoi'];
        $sanPham->thongtinchitiet = $validated['thongtinchitiet'];
        $sanPham->capsanpham = $validated['capsanpham'];
        $sanPham->thoidiemcongbohoanthanh = $validated['thoidiemcongbohoanthanh'];
        $sanPham->save();
        return new ResponseSuccess("Cập nhật sản phẩm thành công", true);
    }


    public function updateDeTai(UpdateDeTaiRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $deTai = DeTai::where('id_sanpham', $id_sanpham)->first();
        if ($deTai == null) {
            throw new DeTaiNotFoundException();
        }

        // check đề tài đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($deTai->sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('detai.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($deTai->sanPham == null) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đúng loại sản phẩm là đề tài
        if ($deTai->sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        $validated = $request->validated();

        $deTai->maso = $validated['maso'];
        $deTai->ngaydangky = $validated['ngaydangky'];
        $deTai->ngoaitruong = $validated['ngoaitruong'];
        $deTai->truongchutri = $validated['ngoaitruong'] == true ? $validated['truongchutri'] : null;
        $deTai->id_tochucchuquan = $validated['ngoaitruong'] == true ? $validated['id_tochucchuquan'] : null;
        $deTai->id_loaidetai = $validated['ngoaitruong'] == false ? $validated['id_loaidetai'] : null;
        $deTai->detaihoptac = $validated['detaihoptac'];
        $deTai->id_tochuchoptac = $validated['detaihoptac'] == true ? $validated['id_tochuchoptac'] : null;
        $deTai->tylekinhphidonvihoptac = $validated['detaihoptac'] == true ? $validated['tylekinhphidonvihoptac'] : null;
        $deTai->capdetai = $validated['capdetai'];
        $deTai->save();
        return new ResponseSuccess("Cập nhật đề tài thành công", true);
    }


    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }

        // Check san pham trong trang thai softDelete thi khong cho chinh sua
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        // check đề tài đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('detai.status')) {
                throw new PermissionUpdateTacGiaDeTaiException();
            }
        }        

        $validated = $request->validated();
        $result = [];


        DB::transaction(function () use ($validated, &$sanPham, &$result) {
            $listIdTacGia = [];
            $listIdVaiTro = [];
            $thuTus = [];
            $tyLeDongGops = [];
            $listSanPhamTacGia = $validated['sanpham_tacgia'];

            // Lọc ra những sanphamtacgia có id_tacgia = nul
            $filteredWithoutIdTacGia = array_filter($listSanPhamTacGia, function ($object) {
                return is_null($object['id_tacgia']);
            });

            // Lọc ra những to chuc tác giả có id_tacgia != nul
            $filteredWithoutIdToChuc = array_filter($listSanPhamTacGia, function ($object) {
                if (!is_null($object['tochuc'])) {
                    return is_null($object['tochuc']['id_tochuc']);
                }
            });


            // check những tác giả ngoài thì thêm vào hệ thống
            if (count($filteredWithoutIdTacGia) > 0) {
                $listSanPhamTacGia = $this->keKhaiTacGia($listSanPhamTacGia);
            }


            // check những tổ chức ngoài thì thêm vào hệ thống
            if (count($filteredWithoutIdToChuc) > 0) {
                $listSanPhamTacGia = $this->keKhaiToChuc($listSanPhamTacGia);
            }
            $test = $listSanPhamTacGia;

            //            // add tổ chức cho tác giả
            foreach ($listSanPhamTacGia as $sanPhamTacGia) {
                $user = User::find($sanPhamTacGia['id_tacgia']);
                if ($user == null) {
                    throw new UserNotFoundException();
                }
                if ($sanPhamTacGia['tochuc'] && $sanPhamTacGia['tochuc']['id_tochuc']) {
                    $user->id_tochuc = $sanPhamTacGia['tochuc']['id_tochuc'];
                    $user->save();
                }
            }


            // Kiểm tra các vai trò tác giả phải là vai trò tác giả của đề tài 
            foreach ($listSanPhamTacGia as $sanPhamTacGia) {
                foreach ($sanPhamTacGia['list_id_vaitro'] as $idvaitro) {
                    if (DMVaiTroTacGia::where([['role', '=', 'detai'], ['id', '=', $idvaitro]])->first() == null) {
                        throw new VaiTroOfDeTaiException();
                    }
                    $listIdTacGia[] = $sanPhamTacGia['id_tacgia'];
                    $listIdVaiTro[] = $idvaitro;
                    $thuTus[] = $sanPhamTacGia['thutu'];
                    $tyLeDongGops[] = $sanPhamTacGia['tyledonggop'];
                }
            }


            $vaiTros = DMVaiTroTacGia::whereIn('id', $listIdVaiTro)->get();

            // Kiểm tra đề tài phải có chủ nhiệm
            $flag = false;
            foreach ($vaiTros as $vaiTro) {
                if ($vaiTro->mavaitro == 'chunhiem') {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                throw new DeTaiNotHaveChuNhiemException();
            }

            // kiểm tra 1 người có 2 vai trò giống nhau trong đề tài
            for ($i = 0; $i < count($listIdTacGia) - 1; $i++) {
                for ($z = $i + 1; $z < count($listIdVaiTro); $z++) {
                    if (($listIdTacGia[$i] == $listIdTacGia[$z]) && ($listIdVaiTro[$i] == $listIdVaiTro[$z])) {
                        throw new TwoRoleSimilarForOnePersonInDeTaiException();
                    }
                }
            }

            // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
            $allVaiTroDB = DMVaiTroTacGia::all();
            foreach ($allVaiTroDB as $vaitro) {
                if ($vaitro->mavaitro == 'chunhiem') {
                    $idVaiTroChuNhiem = $vaitro->id;
                }
            }
            if (isset(array_count_values($listIdVaiTro)[$idVaiTroChuNhiem]) && array_count_values($listIdVaiTro)[$idVaiTroChuNhiem] >= 2) {
                throw new RoleOnlyHeldByOnePersonInDeTaiException();
            }

            $dmSanPhamDeTai = DMSanPham::where('masanpham', 'detai')->first();
            if ($dmSanPhamDeTai == null) {
                throw new CreateDeTaiFailedException();
            }

            SanPhamTacGia::where('id_sanpham', $sanPham->id)->forceDelete();
            for ($i = 0; $i < count($listIdTacGia); $i++) {
                $tacGiaId = $listIdTacGia[$i];
                $vaiTroId = $listIdVaiTro[$i];
                $thuTu = isset($thuTus[$i]) ? $thuTus[$i] : null;
                $tyLeDongGop = isset($tyLeDongGops[$i]) ? $tyLeDongGops[$i] : null;
                $sanPhamTacGia = SanPhamTacGia::create([
                    'id_sanpham' => $sanPham->id,
                    'id_tacgia' => $tacGiaId,
                    'id_vaitrotacgia' => $vaiTroId,
                    'thutu' => $thuTu,
                    'tyledonggop' => $tyLeDongGop
                ]);
                $result[] = Convert::getSanPhamTacGiaVm($sanPhamTacGia);
            }

            // update so tac gia cho bai bao
            $sanPham->tongsotacgia = count(array_unique($listIdTacGia));
            $sanPham->save();
        });
        return new ResponseSuccess("Cập nhật tác giả thành công", $result);
    }


    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        $fileMinhChung = FileMinhChungSanPham::where('id_sanpham', $id_sanpham)->first();
        if ($fileMinhChung == null) {
            throw new FileMinhChungNotFoundException();
        }

        // Check san pham trong trang thai softDelete thi khong cho chinh sua
        if ($fileMinhChung->sanPham == null) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đề tài đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($fileMinhChung->sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('detai.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // check đúng loại sản phẩm là đề tài
        if ($fileMinhChung->sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        $url_file =  $this->googleDriveService->uploadFile($request->file('file'));
        $fileMinhChung->url = $url_file->link_view;
        $fileMinhChung->save();

        return new ResponseSuccess("Cập nhật file minh chứng thành công", $url_file->link_view);
    }


    public function updateTrangThaiRaSoatDeTai(UpdateTrangThaiRaSoatRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }
        // Check san pham trong trang thai softDelete thi khong cho chinh sua
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        $validated = $request->validated();
        if ($sanPham->trangthairasoat == $validated['trangthairasoat']) {
            throw new UpdateTrangThaiRaSoatException();
        }
        $sanPham->trangthairasoat = $validated['trangthairasoat'];
        $sanPham->id_nguoirasoat = auth('api')->user()->id;
        $sanPham->ngayrasoat = date("Y-m-d H:i:s");
        $sanPham->save();
        return new ResponseSuccess("Cập nhật trạng thái thành công", true);
    }

    public function tuyenChonDeTai(TuyenChonDeTaiRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }
        // Check san pham đề tài trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }
        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }
        // check đề tài đã xác nhận thì mới được tuyển chọn
        if ($sanPham->trangthairasoat == 'Đang rà soát') {
            throw new DeTaiNotXacNhanException();
        }

        // check de tai khong co trong tuyen chon, xet duyet, bao cao, nghiem thu
        if (!empty(TuyenChon::where('id_sanpham', $id_sanpham)->first()) || !empty(XetDuyet::where('id_sanpham', $id_sanpham)->first()) || !empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotTuyenChonException();
        }

        $validated = $request->validated();
        $tuyenChon = TuyenChon::create([
            'id_sanpham' => $sanPham->id,
            'ketquatuyenchon' => $validated['ketquatuyenchon'],
            'lydo' =>  $validated['lydo']
        ]);

        $result = Convert::getTuyenChonVm($tuyenChon);
        return new ResponseSuccess("Tuyển chọn đề tài thành công", $result);
    }



    public function xetDuyetDeTai(XetDuyetDeTaiRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }
        // Check san pham đề tài trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }
        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        // check đề tài đã xác nhận thì mới được xét duyệt
        if ($sanPham->trangthairasoat == 'Đang rà soát') {
            throw new DeTaiNotXacNhanException();
        }

        // check đề tải đã được tuyển chọn thì mới được xét duyệt
        if (empty(TuyenChon::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotXetDuyetException("Đề tài chưa được tuyển chọn");
        }

        // check kết quả tuyển chọn đề tài là đủ điều kiện thì mới cho xết duyệt
        if ($sanPham->tuyenChon->ketquatuyenchon != "Đủ điều kiện") {
            throw new KetQuaTuyenChonDeTaiException();
        }


        // check đề tài không đủ điều kiện xét duyệt ( đã được xét duyệt hoặc đã được nghiệm thu)
        if (!empty(XetDuyet::where('id_sanpham', $id_sanpham)->first()) || !empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotXetDuyetException("Đề tài đã được xét duyệt hoặc đã được nghiệm thu trước đó");
        }

        $validated = $request->validated();
        $xetDuyet = XetDuyet::create([
            'id_sanpham' => $sanPham->id,
            'ngayxetduyet' => $validated['ngayxetduyet'],
            'ketquaxetduyet' => $validated['ketquaxetduyet'],
            'sohopdong' => $validated['ketquaxetduyet'] == "Đủ điều kiện" ? $validated['sohopdong'] : null,
            'ngaykyhopdong' => $validated['ketquaxetduyet'] == "Đủ điều kiện" ? $validated['ngaykyhopdong'] : null,
            'thoihanhopdong' => $validated['ketquaxetduyet'] == "Đủ điều kiện" ? $validated['thoihanhopdong'] : null,
            'kinhphi' => $validated['ketquaxetduyet'] == "Đủ điều kiện" ? $validated['kinhphi'] : null
        ]);
        $result = Convert::getXetDuyetVm($xetDuyet);
        return new ResponseSuccess("Xét duyệt đề tài thành công", $result);
    }



    public function baoCaoTienDoDeTai(BaoCaoTienDoDeTaiRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }
        // Check san pham đề tài trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }
        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }
        // check đề tài đã xác nhận thì mới được báo cáo
        if ($sanPham->trangthairasoat == 'Đang rà soát') {
            throw new DeTaiNotXacNhanException();
        }
        // check đề tải đã được tuyển chọn và đã đc xet duyệt thì mới cho báo cáo
        if (empty(TuyenChon::where('id_sanpham', $id_sanpham)->first()) || empty(XetDuyet::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotBaoCaoException("Đề tài đã được tuyển chọn và xét duyệt mới có thể báo cáo");
        }
        // check kết quả tuyển chọn đề tài là đủ điều kiện thì mới cho báo cáo
        if ($sanPham->tuyenChon->ketquatuyenchon != "Đủ điều kiện") {
            throw new KetQuaTuyenChonDeTaiException();
        }
        // check kết quả xét duyệt đề tài là đủ điều kiện thì mới cho báo cáo
        if ($sanPham->xetDuyet->ketquaxetduyet != "Đủ điều kiện") {
            throw new KetQuaXetDuyetDeTaiException();
        }


        // check đề tài không đủ điều kiện báo cáo tiến độ (đã được nghiệm thu)
        if (!empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotBaoCaoException("Đề tài đã được nghiệm thu trước đó");
        }

        $validated = $request->validated();
        $baoCao = BaoCaoTienDo::create([
            'id_sanpham' => $sanPham->id,
            'tenbaocao' => $validated['tenbaocao'],
            'ngaynopbaocao' => $validated['ngaynopbaocao'],
            'ketquaxet' => $validated['ketquaxet'],
            'thoigiangiahan' => $validated['thoigiangiahan'],
        ]);
        $result = Convert::getBaoCaoTienDoVm($baoCao);
        return new ResponseSuccess("Báo cáo tiến độ đề tài thành công", $result);
    }


    public function nghiemThuDeTai(NghiemThuDeTaiRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }
        // Check san pham đề tài trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }
        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }
        // check đề tài đã xác nhận thì mới được nghiệm thu
        if ($sanPham->trangthairasoat == 'Đang rà soát') {
            throw new DeTaiNotXacNhanException();
        }
        // check đề tải đã được tuyển chọn và đã đc xet duyệt thì mới cho nghiệm thu
        if (empty(TuyenChon::where('id_sanpham', $id_sanpham)->first()) || empty(XetDuyet::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotNghiemThuException("Đề tài đã được tuyển chọn và đã đc xet duyệt thì mới có thể nghiệm thu");
        }

        // check kết quả tuyển chọn đề tài là đủ điều kiện thì mới cho nghiệm thu
        if ($sanPham->tuyenChon->ketquatuyenchon != "Đủ điều kiện") {
            throw new KetQuaTuyenChonDeTaiException();
        }
        // check kết quả xét duyệt đề tài là đủ điều kiện thì mới cho nghiệm thu
        if ($sanPham->xetDuyet->ketquaxetduyet != "Đủ điều kiện") {
            throw new KetQuaXetDuyetDeTaiException();
        }


        // check đề tài không đủ điều kiện nghiệm thu (đã được nghiệm thu)
        if (!empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            throw new DeTaiCanNotNghiemThuException("Đề tài đã được nghiệm thu trước đó");
        }

        $validated = $request->validated();
        $nghiemThu = NghiemThu::create([
            'id_sanpham' => $sanPham->id,
            'ngaynghiemthu' => $validated['ngaynghiemthu'],
            'ketquanghiemthu' => $validated['ketquanghiemthu'],
            'ngaycongnhanhoanthanh' => $validated['ketquanghiemthu'] == "Đủ điều kiện" ? $validated['ngaycongnhanhoanthanh'] : null,
            'soqdcongnhanhoanthanh' => $validated['ketquanghiemthu'] == "Đủ điều kiện" ? $validated['soqdcongnhanhoanthanh'] : null,
        ]);
        $result = Convert::getNghiemThuVm($nghiemThu);
        return new ResponseSuccess("Nghiệm thu đề tài thành công", $result);
    }


    public function getLichSuBaoCao(Request $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;

        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }

        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null || $sanPham->dmSanPham->masanpham != 'detai') {
            throw new DeTaiNotFoundException();
        }

        $page = $request->query('page', 1);

        $result = [];
        $baoCaoTienDos = BaoCaoTienDo::where('id_sanpham', '=', $id_sanpham)->orderBy('created_at', 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($baoCaoTienDos as $baoCaoTienDo) {
            $result[] = Convert::getBaoCaoTienDoVm($baoCaoTienDo);
        }
        $pagingResponse = new PagingResponse($baoCaoTienDos->lastPage(), $baoCaoTienDos->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function deleteDeTai(int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }

        // Kiểm tra nếu đề tài đã nghiệm thu thì chỉ có sp admin mới được phép xóa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        $flag = false;
        $deTaiNghiemThu = false;
        if (!empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            $deTaiNghiemThu = true;
            foreach ($userCurrent->roles as $role) {
                if ($role->mavaitro == 'super_admin') {
                    $flag = true;
                }
            }
        }
        if ($deTaiNghiemThu && !$flag) {
            throw new UserNotHavePermissionException();
        }


        if (!$sanPham->delete()) {
            throw new DeleteFailException();
        }
        return new ResponseSuccess("Xóa đề tài thành công", true);
    }

    public function restoreDeTai(int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::onlyTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }

        // Kiểm tra nếu đề tài đã nghiệm thu thì chỉ có sp admin mới được khôi phục
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        $flag = false;
        $deTaiNghiemThu = false;
        if (!empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            $deTaiNghiemThu = true;
            foreach ($userCurrent->roles as $role) {
                if ($role->mavaitro == 'super_admin') {
                    $flag = true;
                }
            }
        }
        if ($deTaiNghiemThu && !$flag) {
            throw new UserNotHavePermissionException();
        }

        SanPham::onlyTrashed()->where('id', $id_sanpham)->restore();
        return new ResponseSuccess("Hoàn tác đề tài thành công", true);
    }

    public function forceDeleteDeTai(int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::onlyTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new DeTaiNotFoundException();
        }

        // Kiểm tra nếu đề tài đã nghiệm thu thì chỉ có sp admin mới được phép xóa hẳn
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        $flag = false;
        $deTaiNghiemThu = false;
        if (!empty(NghiemThu::where('id_sanpham', $id_sanpham)->first())) {
            $deTaiNghiemThu = true;
            foreach ($userCurrent->roles as $role) {
                if ($role->mavaitro == 'super_admin') {
                    $flag = true;
                }
            }
        }
        if ($deTaiNghiemThu && !$flag) {
            throw new UserNotHavePermissionException();
        }

        SanPham::onlyTrashed()->where('id', $id_sanpham)->forceDelete();
        return new ResponseSuccess("Xóa đề tài thành công", true);
    }

    private function randomUnique()
    {
        $microtime = microtime(true);

        list($integerPart, $decimalPart) = explode('.', $microtime);

        // Take the last 5 digits of the decimal part
        $lastFiveDigits = substr($decimalPart, -5);

        // Combine integer part and the last 5 digits
        $result = $lastFiveDigits;
        return $result;
    }

    private function filterUniqueAndDuplicates($array, $field)
    {
        $resultArray = [];
        $values = [];
        foreach ($array as $index => $item) {
            $value = $item[$field];
            if (!array_key_exists($value, $values)) {
                $values[$value] = ['object' => $item, 'duplicates' => [$index]];
            } else {
                $values[$value]['duplicates'][] = $index;
            }
        }
        // Lưu các đối tượng duy nhất và index của các đối tượng trùng lặp vào mảng kết quả
        foreach ($values as $value) {
            // Nếu có các đối tượng trùng lặp, thêm trường duplicates vào object
            if (!empty($value['duplicates'])) {
                $value['object']['duplicates'] = $value['duplicates'];
            }
            $resultArray[] = $value['object'];
        }
        return $resultArray;
    }

    public function getDeTaiKeKhai(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->where('d_m_san_phams.masanpham', '=', 'detai')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%');
            })->where('san_phams.id_nguoikekhai', auth('api')->user()->id)
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getDeTaiVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }

    public function getDeTaiThamGia(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
            ->where('d_m_san_phams.masanpham', '=', 'detai')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%');
            })->where('san_pham_tac_gias.id_tacgia', auth('api')->user()->id)
            ->groupBy('san_phams.id')
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getDeTaiVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }



    public function updateDeTaiForUser(UpdateDeTaiForUserRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $deTai = DeTai::where('id_sanpham', $id_sanpham)->first();
        $sanPham = SanPham::find($id_sanpham);
        if ($deTai == null || $sanPham == null) {
            throw new DeTaiNotFoundException();
        }


        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đề tài đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;

        if ($sanPham->nguoiKeKhai->id != $idUserCurent) {
            throw new ChuDeTaiException();
        }

        $userCurrent = User::find($idUserCurent);
        if ($deTai->sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('detai.status')) {
                throw new UserNotHavePermissionException();
            }
        }


        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        // Update khi không còn lỗi
        $validated = $request->validated();
        DB::transaction(function () use ($validated, $sanPham, $deTai) {

            $donVi = !empty($validated['sanpham']['donvi']) ? $validated['sanpham']['donvi'] : null;
            $toChucChuQuan = !empty($validated['tochucchuquan']) ? $validated['tochucchuquan'] : null;
            $toChucHopTac = !empty($validated['tochuchoptac']) ? $validated['tochuchoptac'] : null;

            // check có nhận tài trợ và đơn vị tài trợ ngoài thì thêm mới vào hệ thống
            if ($donVi != null) {
                if ($validated['sanpham']['donvi']['id_donvi'] == null && $validated['sanpham']['conhantaitro']) {
                    $validated['sanpham']['donvi']['id_donvi'] = $this->keKhaiDonVi($validated['sanpham']['donvi']);
                }
            }

            // check đề tài ngoài trường và tổ chức chủ quản ngoài thì thêm mới vào hệ thống
            if ($toChucChuQuan != null) {
                if ($validated['tochucchuquan']['id_tochucchuquan'] == null && $validated['ngoaitruong']) {
                    $validated['tochucchuquan']['id_tochucchuquan'] = $this->keKhaiToChucChuQuan($validated['tochucchuquan']);
                }
            }


            // check đề tài có phải đề tài hợp tác và tổ chức hơp tác ngoài thì thêm mới vào hệ thống
            if ($toChucHopTac != null) {
                if ($validated['tochuchoptac']['id_tochuchoptac'] == null && $validated['detaihoptac']) {
                    $validated['tochuchoptac']['id_tochuchoptac'] = $this->keKhaiToChucHopTac($validated['tochuchoptac']);
                }
            }


            // Update san pham
            $sanPham->tensanpham = $validated['sanpham']['tensanpham'];
            $sanPham->conhantaitro = $validated['sanpham']['conhantaitro'];
            $sanPham->id_donvitaitro = $validated['sanpham']['conhantaitro'] == true && !empty($validated['sanpham']['donvi']['id_donvi']) ? $validated['sanpham']['donvi']['id_donvi'] : null;
            $sanPham->chitietdonvitaitro = $validated['sanpham']['conhantaitro'] == true ? $validated['sanpham']['chitietdonvitaitro'] : null;
            $sanPham->save();

            // Update de tai
            $deTai->maso = $validated['maso'];
            $deTai->ngoaitruong = $validated['ngoaitruong'];
            $deTai->truongchutri = $validated['ngoaitruong'] == true ? $validated['truongchutri'] : null;
            $deTai->id_tochucchuquan = $validated['ngoaitruong'] == true && !empty($validated['tochucchuquan']['id_tochucchuquan']) ? $validated['tochucchuquan']['id_tochucchuquan'] : null;
            $deTai->id_loaidetai = $validated['id_loaidetai'];
            $deTai->detaihoptac = $validated['detaihoptac'];
            $deTai->id_tochuchoptac = $validated['detaihoptac'] == true && !empty($validated['tochuchoptac']['id_tochuchoptac']) ? $validated['tochuchoptac']['id_tochuchoptac'] : null;
            $deTai->tylekinhphidonvihoptac = $validated['detaihoptac'] == true ? $validated['tylekinhphidonvihoptac'] : null;
            $deTai->capdetai = $validated['capdetai'];
            $deTai->save();
        });
        return new ResponseSuccess("Cập nhật đề tài thành công", true);
    }

    public function UploadFileMinhChung(UploadFileMinhChungRequest $request):ResponseSuccess{
        $result = $this->googleDriveService->uploadFile($request->file('file'));
        return new ResponseSuccess("Upload file minh chứng thành công",$result);
    }
}
