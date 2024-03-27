<?php

namespace App\Service\BaiBao;

use App\Exceptions\BaiBao\BaiBaoCanNotUpdateException;
use App\Exceptions\BaiBao\BaiBaoKhoaHocNotFoundException;
use App\Exceptions\BaiBao\BaiBaoNotHaveFirstAuthor;
use App\Exceptions\BaiBao\ChuBaiBaoException;
use App\Exceptions\BaiBao\CreateBaiBaoFailedException;
use App\Exceptions\BaiBao\RoleOnlyHeldByOnePersonException;
use App\Exceptions\BaiBao\TrungKeywordException;
use App\Exceptions\BaiBao\TwoRoleSimilarForOnePersonException;
use App\Exceptions\BaiBao\VaiTroOfBaiBaoException;
use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\InvalidValueException;
use App\Exceptions\SanPham\FileMinhChungNotFoundException;
use App\Exceptions\SanPham\LoaiSanPhamWrongException;
use App\Exceptions\SanPham\UpdateTrangThaiRaSoatException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotHavePermissionException;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoForUserRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\BaiBao\Keyword;
use App\Models\FileMinhChungSanPham;
use App\Models\Role;
use App\Models\SanPham\DMSanPham;
use App\Models\SanPham\DMVaiTroTacGia;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\TapChi\TapChi;
use App\Models\User;
use App\Models\UserInfo\DMToChuc;
use App\Service\GoogleDrive\GoogleDriveService;
use App\Service\TapChi\TapChiService;
use App\Service\User\UserService;
use App\Service\UserInfo\ToChucService;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BaiBaoServiceImpl implements BaiBaoService
{

    private UserService $userService;
    private TapChiService $tapChiService;
    private ToChucService $toChucService;
    private KeywordService $keywordService;
    private GoogleDriveService $googleDriveService;

    public function __construct(
        UserService $userService,
        TapChiService $tapChiService,
        ToChucService $toChucService,
        KeywordService $keywordService,
        GoogleDriveService $googleDriveService
    )
    {
        $this->userService = $userService;
        $this->tapChiService = $tapChiService;
        $this->toChucService = $toChucService;
        $this->keywordService = $keywordService;
        $this->googleDriveService = $googleDriveService;
    }

    public function getBaiBaoPaging(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $isLock = $request->query('isLock', 0);
        $sanPhams = null;
        if ($isLock == 1) {
            $sanPhams = SanPham::onlyTrashed()->select('san_phams.*')
                ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                ->where('d_m_san_phams.masanpham', '=', 'baibaokhoahoc')
                ->where(function ($query) use ($keysearch) {
                    $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                        ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                })
                ->groupBy('san_phams.id')
                ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        } else { // Lấy những bản ghi không bị xóa mềm           
            $sanPhams = SanPham::select('san_phams.*')
                ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
                ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
                ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
                ->where('d_m_san_phams.masanpham', '=', 'baibaokhoahoc')
                ->where(function ($query) use ($keysearch) {
                    $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                        ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
                })->where('san_phams.trangthairasoat', 'Đã xác nhận')
                ->groupBy('san_phams.id')
                ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        }
        $result = [];
        // $sanPhams = SanPham::where('tensanpham', 'LIKE', '%' . 'Báo' . '%')->where('id_loaisanpham', 1)->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham);
        }

        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }



    public function getBaiBaoPagingForUser(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
            ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
            ->where('d_m_san_phams.masanpham', '=', 'baibaokhoahoc')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
            })->where('san_phams.trangthairasoat', 'Đã xác nhận')
            ->groupBy('san_phams.id')
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }




    public function getBaiBaoChoDuyet(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
            ->join('users', 'san_pham_tac_gias.id_tacgia', '=', 'users.id')
            ->where('d_m_san_phams.masanpham', '=', 'baibaokhoahoc')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('users.name', 'LIKE', '%' . $keysearch . '%');
            })->where('san_phams.trangthairasoat', 'Đang rà soát')
            ->groupBy('san_phams.id')
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }




    public function getDetailBaiBao(int $id): ResponseSuccess
    {
        $id_sanpham = $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null || $sanPham->dmSanPham->masanpham != "baibaokhoahoc") {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        $result = Convert::getBaiBaoKhoaHocDetailVm($sanPham);
        return new ResponseSuccess("Thành công", $result);
    }


    public function getDetailBaiBaoForUser(int $id): ResponseSuccess
    {
        $id_sanpham = $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null || $sanPham->dmSanPham->masanpham != "baibaokhoahoc") {
            throw new BaiBaoKhoaHocNotFoundException();
        }

        if ($sanPham->trangthairasoat == "Đang rà soát") {
            throw new BaiBaoKhoaHocNotFoundException();
        }


        $result = Convert::getBaiBaoKhoaHocDetailVm($sanPham);
        $result->sanpham->ngayrasoat = null;
        $result->sanpham->nguoirasoat = null;


        return new ResponseSuccess("Thành công", $result);
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


    public function createBaiBao(CreateBaiBaoRequest $request): ResponseSuccess
    {
        $validated = $request->validated();

        $baiBao = new BaiBaoKhoaHoc();
        $sanPham = new SanPham();


        DB::transaction(function () use ($validated, &$baiBao, &$sanPham) {
            $listIdTacGia = [];
            $listIdVaiTro = [];
            $thuTus = [];
            $tyLeDongGops = [];
            $listSanPhamTacGia = $validated['sanpham_tacgia'];

            $listKeyword = !empty($validated['keywords']) ? $validated['keywords'] : null;
            $donVi = !empty($validated['sanpham']['donvi']) ? $validated['sanpham']['donvi'] : null;
            $tapChi = !empty($validated['tapchi']) ? $validated['tapchi'] : null;

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


            // Lọc ra  những keyword có id_keyword = null
            $filteredWithoutIdKeyword = [];
            if ($listKeyword != null) {
                $filteredWithoutIdKeyword = array_filter($listKeyword, function ($object) {
                    return is_null($object['id_keyword']);
                });
            }

            // check có nhận tài trợ và đơn vị tài trợ ngoài thì thêm mới vào hệ thống
            if ($donVi != null) {
                if ($validated['sanpham']['donvi']['id_donvi'] == null && $validated['sanpham']['conhantaitro']) {
                    $validated['sanpham']['donvi']['id_donvi'] = $this->keKhaiDonVi($validated['sanpham']['donvi']);
                }
            }


            // check tạp chí ngoài thì thêm mới vào hệ thống
            if ($tapChi != null) {
                if ($validated['tapchi']['id_tapchi'] == null) {
                    $validated['tapchi']['id_tapchi'] = $this->keKhaiTapChi($validated['tapchi']);
                }
            }


            // check có keyword ngoài thì thêm mới vào hệ thống
            if ($listKeyword != null) {
                if (count($filteredWithoutIdKeyword) > 0) {
                    $validated['keywords'] = $this->keKhaiKeyword($listKeyword);
                }
            } else {
                $validated['keywords'] = [];
            }


            // check những tác giả ngoài thì thêm vào hệ thống
            if (count($filteredWithoutIdTacGia) > 0) {
                $listSanPhamTacGia = $this->keKhaiTacGia($listSanPhamTacGia);
            }


            // check trung keyword
            if ($listKeyword != null) {
                $keywords = $validated['keywords'];
                $listIdKeyword = [];
                foreach ($keywords as $keyword) {
                    $listIdKeyword[] = $keyword['id_keyword'];
                }
                $valueCounts = array_count_values($listIdKeyword);
                foreach ($valueCounts as $count) {
                    if ($count > 1) {
                        throw new TrungKeywordException();
                    }
                }
            }


            // check những tổ chức ngoài thì thêm vào hệ thống
            if (count($filteredWithoutIdToChuc) > 0) {
                $listSanPhamTacGia = $this->keKhaiToChuc($listSanPhamTacGia);
            }

            // add tổ chức cho tác giả
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


            // Kiểm tra các vai trò tác giả phải là vai trò tác giả của bài báo 
            foreach ($listSanPhamTacGia as $sanPhamTacGia) {
                foreach ($sanPhamTacGia['list_id_vaitro'] as $idvaitro) {
                    if (DMVaiTroTacGia::where([['role', '=', 'baibao'], ['id', '=', $idvaitro]])->first() == null) {
                        throw new VaiTroOfBaiBaoException();
                    }
                    $listIdTacGia[] = $sanPhamTacGia['id_tacgia'];
                    $listIdVaiTro[] = $idvaitro;
                    $thuTus[] = $sanPhamTacGia['thutu'];
                    $tyLeDongGops[] = $sanPhamTacGia['tyledonggop'];
                }
            }

            $vaiTros = DMVaiTroTacGia::whereIn('id', $listIdVaiTro)->get();

            // Kiểm tra bài báo phải có tác giả đầu tiên
            $flag = false;
            foreach ($vaiTros as $vaiTro) {
                if ($vaiTro->mavaitro == 'tacgiadautien') {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                throw new BaiBaoNotHaveFirstAuthor();
            }

            // kiểm tra 1 người có 2 vai trò giống nhau trong bài báo
            for ($i = 0; $i < count($listIdTacGia) - 1; $i++) {
                for ($z = $i + 1; $z < count($listIdVaiTro); $z++) {
                    if (($listIdTacGia[$i] == $listIdTacGia[$z]) && ($listIdVaiTro[$i] == $listIdVaiTro[$z])) {
                        throw new TwoRoleSimilarForOnePersonException();
                    }
                }
            }

            // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
            $allVaiTroDB = DMVaiTroTacGia::all();
            foreach ($allVaiTroDB as $vaitro) {
                if ($vaitro->mavaitro == 'tacgiadautien') {
                    $idVaiTroTacGiaDauTien = $vaitro->id;
                }
                if ($vaitro->mavaitro == 'tacgialienhe') {
                    $idVaiTroTacGiaLienHe = $vaitro->id;
                }
            }
            if ((isset(array_count_values($listIdVaiTro)[$idVaiTroTacGiaDauTien]) && array_count_values($listIdVaiTro)[$idVaiTroTacGiaDauTien] >= 2) || (isset(array_count_values($listIdVaiTro)[$idVaiTroTacGiaLienHe]) && array_count_values($listIdVaiTro)[$idVaiTroTacGiaLienHe] >= 2)) {
                throw new RoleOnlyHeldByOnePersonException();
            }

            $dmSanPhamBaiBao = DMSanPham::where('masanpham', 'baibaokhoahoc')->first();
            if ($dmSanPhamBaiBao == null) {
                throw new CreateBaiBaoFailedException();
            }

            // Thực hiên insert khi không còn lỗi
            $sanPham = SanPham::create([
                'tensanpham' => $validated['sanpham']['tensanpham'],
                'id_loaisanpham' => $dmSanPhamBaiBao->id,
                'tongsotacgia' => $validated['sanpham']['tongsotacgia'],
                'conhantaitro' => $validated['sanpham']['conhantaitro'],
                'id_donvitaitro' => $validated['sanpham']['conhantaitro'] == true && !empty($validated['sanpham']['donvi']['id_donvi']) ? $validated['sanpham']['donvi']['id_donvi'] : null,
                'chitietdonvitaitro' => $validated['sanpham']['conhantaitro'] == true && !empty($validated['sanpham']['chitietdonvitaitro']) ? $validated['sanpham']['chitietdonvitaitro'] : null,
                'ngaykekhai' => date("Y-m-d"),
                'id_nguoikekhai' => auth('api')->user()->id,
                'trangthairasoat' => "Đang rà soát",
                'thoidiemcongbohoanthanh' => $validated['sanpham']['thoidiemcongbohoanthanh']
            ]);
            $baiBao = BaiBaoKhoaHoc::create([
                'id_sanpham' => $sanPham->id,
                'doi' => $validated['doi'],
                'url' => $validated['url'],
                'received' => $validated['received'],
                'accepted' => $validated['accepted'],
                'published' => $validated['published'],
                'abstract' => $validated['abstract'],
                'id_tapchi' => $validated['tapchi']['id_tapchi'],
                'volume' => $validated['volume'],
                'issue' => $validated['issue'],
                'number' => $validated['number'],
                'pages' => $validated['pages']
            ]);
            $listIdKeyword = [];
            if ($listKeyword != null) {
                foreach ($validated['keywords'] as $keyword) {
                    $listIdKeyword[] = $keyword['id_keyword'];
                }
            }
            $baiBao->keyWords()->attach($listIdKeyword);

            FileMinhChungSanPham::create([
                'id_sanpham' => $sanPham->id,
                'url' => $validated['fileminhchungsanpham']['url'],
            ]);

            // Kiểm tra nếu bài báo này kh có tác giả nào đảm nhiệm vai trò tác giả liên hệ
            // (có id =2) thì set vai trò đó cho người có vai trò tác giả đứng đầu (có id =1) 
            if (!in_array($idVaiTroTacGiaLienHe, $listIdVaiTro)) {
                $key = array_search($idVaiTroTacGiaDauTien, $listIdVaiTro);
                $listIdVaiTro[] = $idVaiTroTacGiaLienHe;
                $listIdTacGia[] = $listIdTacGia[$key];
            }
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
        $result = Convert::getBaiBaoKhoaHocVm($sanPham);
        return new ResponseSuccess("Tạo bài báo khoa học thành công", $result);
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
                $toChucFind = DMToChuc::where('matochuc', $item['tochuc']['matochuc'])->get()->first();
                if ($toChucFind == null) {
                    $array = [
                        'matochuc' => $item['tochuc']['matochuc'],
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
        $donViFind = DMToChuc::where('matochuc', $donVi['matochuc'])->get()->first();
        if ($donViFind == null) {
            $array = [
                'matochuc' => $donVi['matochuc'],
                'tentochuc' => $donVi['tentochuc'],
            ];
            $donViTaiTro = $this->toChucService->themToChucNgoai($array);
            return $donViTaiTro->id;
        }
        return $donViFind->id;
    }



    private function keKhaiTapChi($tapChi)
    {
        $array = [
            'name' => $tapChi['name'],
            'issn' => $tapChi['issn'],
            'eissn' => $tapChi['eissn'],
            'pissn' => $tapChi['pissn'],
            'website' => $tapChi['website'],
            'trangthai' => 0,
            'id_nguoithem' => auth('api')->user()->id
        ];
        $tapChi = $this->tapChiService->themTapChiNgoai($array);
        return $tapChi->id;
    }


    private function keKhaiKeyword($listKeyword)
    {
        if (is_array($listKeyword)) {
            // Lọc ra những keyword ngoài cần thêm vào hệ thống
            $keywordNews = array_filter($listKeyword, function ($object) {
                return is_null($object['id_keyword']);
            });

            // Lọc ra những keyword có sẵn trong hệ thống 
            $keyWordOlds = array_filter($listKeyword, function ($object) {
                return !is_null($object['id_keyword']);
            });

            // Lọc ra những keyword kê khai giống nhau (giống name)  thì thông báo lỗi
            $listKeywordSame = $this->filterUniqueAndDuplicates($keywordNews, 'name');
            if (count($listKeywordSame) > 0) {
            }

            // Lưu thông tin của những keyword mới vào hệ thống
            foreach ($keywordNews as $key => $keyword) {
                $array = [
                    'name' => $keyword['name']
                ];
                $keywordMd = $this->keywordService->themKeywordNgoai($array);
                $keywordNews[$key]['id_keyword'] = $keywordMd->id;
            }
            $listKeyword = array_merge($keyWordOlds, $keywordNews);
        }
        // Trả lại dữ liệu đã được cập nhật theo đúng định dạng
        return $listKeyword;
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


    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;

        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }

        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new BaiBaoCanNotUpdateException();
        }

        // check bài báo đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('baibao.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // check đúng loại sản phẩm là bài báo khoa học
        if ($sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
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


    public function updateBaiBao(UpdateBaiBaoRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $baiBao = BaiBaoKhoaHoc::where('id_sanpham', $id_sanpham)->first();
        if ($baiBao == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($baiBao->sanPham == null) {
            throw new BaiBaoCanNotUpdateException();
        }

        // check bài báo đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($baiBao->sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('baibao.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // check đúng loại sản phẩm là bài báo khoa học
        if ($baiBao->sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }


        $validated = $request->validated();

        // check trung keyword
        $keywords = $validated['keywords'];
        $listIdKeyword = [];
        foreach ($keywords as $keyword) {
            $listIdKeyword[] = $keyword['id_keyword'];
        }
        $valueCounts = array_count_values($listIdKeyword);
        foreach ($valueCounts as $count) {
            if ($count > 1) {
                throw new TrungKeywordException();
            }
        }

        // Update khi không còn lỗi
        DB::transaction(function () use ($validated, $baiBao) {
            $baiBao->doi = $validated['doi'];
            $baiBao->url = $validated['url'];
            $baiBao->received = $validated['received'];
            $baiBao->accepted = $validated['accepted'];
            $baiBao->published = $validated['published'];
            $baiBao->abstract = $validated['abstract'];
            $baiBao->id_tapchi = $validated['tapchi']['id_tapchi'];
            $baiBao->volume = $validated['volume'];
            $baiBao->issue = $validated['issue'];
            $baiBao->number = $validated['number'];
            $baiBao->pages = $validated['pages'];
            $baiBao->save();
            $listIdKeyword = [];
            foreach ($validated['keywords'] as $keyword) {
                $listIdKeyword[] = $keyword['id_keyword'];
            }
            $baiBao->keyWords()->sync($listIdKeyword);
        });
        return new ResponseSuccess("Cập nhật bài báo khoa học thành công", true);
    }

    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }

        // Check san pham trong trang thai softDelete thi khong cho chinh sua
        if ($sanPham->trashed()) {
            throw new BaiBaoCanNotUpdateException();
        }

        // check đúng loại sản phẩm là bài báo khoa học
        if ($sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
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


            // Kiểm tra các vai trò tác giả phải là vai trò tác giả của bài báo
            foreach ($listSanPhamTacGia as $sanPhamTacGia) {
                foreach ($sanPhamTacGia['list_id_vaitro'] as $idvaitro) {
                    if (DMVaiTroTacGia::where([['role', '=', 'baibao'], ['id', '=', $idvaitro]])->first() == null) {
                        throw new VaiTroOfBaiBaoException();
                    }
                    $listIdTacGia[] = $sanPhamTacGia['id_tacgia'];
                    $listIdVaiTro[] = $idvaitro;
                    $thuTus[] = $sanPhamTacGia['thutu'];
                    $tyLeDongGops[] = $sanPhamTacGia['tyledonggop'];
                }
            }

            $vaiTros = DMVaiTroTacGia::whereIn('id', $listIdVaiTro)->get();

            // Kiểm tra bài báo phải có tác giả đầu tiên
            $flag = false;
            foreach ($vaiTros as $vaiTro) {
                if ($vaiTro->mavaitro == 'tacgiadautien') {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                throw new BaiBaoNotHaveFirstAuthor();
            }

            // kiểm tra 1 người có 2 vai trò giống nhau trong bài báo
            for ($i = 0; $i < count($listIdTacGia) - 1; $i++) {
                for ($z = $i + 1; $z < count($listIdVaiTro); $z++) {
                    if (($listIdTacGia[$i] == $listIdTacGia[$z]) && ($listIdVaiTro[$i] == $listIdVaiTro[$z])) {
                        throw new TwoRoleSimilarForOnePersonException();
                    }
                }
            }

            // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
            $allVaiTroDB = DMVaiTroTacGia::all();
            foreach ($allVaiTroDB as $vaitro) {
                if ($vaitro->mavaitro == 'tacgiadautien') {
                    $idVaiTroTacGiaDauTien = $vaitro->id;
                }
                if ($vaitro->mavaitro == 'tacgialienhe') {
                    $idVaiTroTacGiaLienHe = $vaitro->id;
                }
            }
            if ((isset(array_count_values($listIdVaiTro)[$idVaiTroTacGiaDauTien]) && array_count_values($listIdVaiTro)[$idVaiTroTacGiaDauTien] >= 2) || (isset(array_count_values($listIdVaiTro)[$idVaiTroTacGiaLienHe]) && array_count_values($listIdVaiTro)[$idVaiTroTacGiaLienHe] >= 2)) {
                throw new RoleOnlyHeldByOnePersonException();
            }



            // Kiểm tra nếu bài báo này kh có tác giả nào đảm nhiệm vai trò tác giả liên hệ
            // (có id =2) thì set vai trò đó cho người có vai trò tác giả đứng đầu (có id =1)
            if (!in_array($idVaiTroTacGiaLienHe, $listIdVaiTro)) {
                $key = array_search($idVaiTroTacGiaDauTien, $listIdVaiTro);
                $listIdVaiTro[] = $idVaiTroTacGiaLienHe;
                $listIdTacGia[] = $listIdTacGia[$key];
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
            throw new BaiBaoCanNotUpdateException();
        }

        // check bài báo đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        $userCurrent = User::find($idUserCurent);
        if ($fileMinhChung->sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('baibao.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // check đúng loại sản phẩm là bài báo khoa học
        if ($fileMinhChung->sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }

        $validated = $request->validated();
        $result =  $this->googleDriveService->uploadFile($request->file('file'));
//        $fileMinhChung->url = $validated['url'];
//        $fileMinhChung->save();
//        $result = Convert::getFileMinhChungSanPhamVm($fileMinhChung);
        return new ResponseSuccess("Cập nhật file minh chứng thành công", $result);
    }


    public function updateTrangThaiRaSoatBaiBao(UpdateTrangThaiRaSoatRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        $sanPham = SanPham::withTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        // Check san pham trong trang thai softDelete thi khong cho chinh sua
        if ($sanPham->trashed()) {
            throw new BaiBaoCanNotUpdateException();
        }

        // check đúng loại sản phẩm là bài báo khoa học
        if ($sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }

        $validated = $request->validated();
        if ($sanPham->trangthairasoat == $validated['trangthairasoat']) {
            throw new UpdateTrangThaiRaSoatException();
        }
        $sanPham->trangthairasoat = $validated['trangthairasoat'];
        $sanPham->id_nguoirasoat = auth('api')->user()->id;
        $sanPham->ngayrasoat = date("Y-m-d");
        $sanPham->save();
        return new ResponseSuccess("Cập nhật trạng thái thành công", true);
    }

    public function deleteBaiBao(int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        if (!$sanPham->delete()) {
            throw new DeleteFailException();
        }
        return new ResponseSuccess("Xóa bài báo thành công", true);
    }


    public function restoreBaiBao(int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::onlyTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        SanPham::onlyTrashed()->where('id', $id_sanpham)->restore();
        return new ResponseSuccess("Hoàn tác bài báo thành công", true);
    }

    public function forceDeleteBaiBao(int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::onlyTrashed()->find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        SanPham::onlyTrashed()->where('id', $id_sanpham)->forceDelete();
        return new ResponseSuccess("Xóa bài báo thành công", true);
    }


    public function getBaiBaoKeKhai(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->where('d_m_san_phams.masanpham', '=', 'baibaokhoahoc')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%');
            })->where('san_phams.id_nguoikekhai', auth('api')->user()->id)
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }

    public function getBaiBaoThamGia(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $sanPhams = SanPham::select('san_phams.*')
            ->join('d_m_san_phams', 'd_m_san_phams.id', '=', 'san_phams.id_loaisanpham')
            ->join('san_pham_tac_gias', 'san_pham_tac_gias.id_sanpham', '=', 'san_phams.id')
            ->where('d_m_san_phams.masanpham', '=', 'baibaokhoahoc')
            ->where(function ($query) use ($keysearch) {
                $query->where('san_phams.tensanpham', 'LIKE', '%' . $keysearch . '%');
            })->where('san_pham_tac_gias.id_tacgia', auth('api')->user()->id)
            ->groupBy('san_phams.id')
            ->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function updateBaiBaoForUser(UpdateBaiBaoForUserRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $sanPham = SanPham::find($id_sanpham);
        $baiBao = BaiBaoKhoaHoc::where('id_sanpham', $id_sanpham)->first();
        if ($baiBao == null || $sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($sanPham->trashed()) {
            throw new BaiBaoCanNotUpdateException();
        }


        // check bài báo đã được xác nhận thì chỉ có admin có quyền mới được chỉnh sửa
        $idUserCurent = auth('api')->user()->id;
        if ($sanPham->nguoiKeKhai->id != $idUserCurent) {
            throw new ChuBaiBaoException();
        }

        $userCurrent = User::find($idUserCurent);
        if ($sanPham->trangthairasoat == "Đã xác nhận") {
            if (!$userCurrent->hasPermission('baibao.status')) {
                throw new UserNotHavePermissionException();
            }
        }

        // check đúng loại sản phẩm là bài báo khoa học
        if ($sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }


        $validated = $request->validated();

        // Update khi không còn lỗi
        DB::transaction(function () use ($validated, $sanPham, $baiBao) {


            $listKeyword = !empty($validated['keywords']) ? $validated['keywords'] : null;
            $donVi = !empty($validated['sanpham']['donvi']) ? $validated['sanpham']['donvi'] : null;
            $tapChi = !empty($validated['tapchi']) ? $validated['tapchi'] : null;



            // Lọc ra  những keyword có id_keyword = null
            $filteredWithoutIdKeyword = [];
            if ($listKeyword != null) {
                $filteredWithoutIdKeyword = array_filter($listKeyword, function ($object) {
                    return is_null($object['id_keyword']);
                });
            }

            // check có keyword ngoài thì thêm mới vào hệ thống
            if ($listKeyword != null) {
                if (count($filteredWithoutIdKeyword) > 0) {
                    $validated['keywords'] = $this->keKhaiKeyword($listKeyword);
                }
            }

            // check trung keyword
            if ($listKeyword != null) {
                $keywords = $validated['keywords'];
                $listIdKeyword = [];
                foreach ($keywords as $keyword) {
                    $listIdKeyword[] = $keyword['id_keyword'];
                }
                $valueCounts = array_count_values($listIdKeyword);
                foreach ($valueCounts as $count) {
                    if ($count > 1) {
                        throw new TrungKeywordException();
                    }
                }
            }


            // check tạp chí ngoài thì thêm mới vào hệ thống
            if ($tapChi != null) {
                if ($validated['tapchi']['id_tapchi'] == null) {
                    $validated['tapchi']['id_tapchi'] = $this->keKhaiTapChi($validated['tapchi']);
                }
            }

            // check có nhận tài trợ và check đơn vị tài trợ ngoài thì thêm mới vào hệ thống
            if ($donVi != null) {
                if ($validated['sanpham']['donvi']['id_donvi'] == null && $validated['sanpham']['conhantaitro']) {
                    $validated['sanpham']['donvi']['id_donvi'] = $this->keKhaiDonVi($validated['sanpham']['donvi']);
                }
            }



            // update phần sản phẩm
            $sanPham->tensanpham = $validated['sanpham']['tensanpham'];
            //            $sanPham->tongsotacgia = $validated['sanpham']['tongsotacgia'];
            $sanPham->conhantaitro = $validated['sanpham']['conhantaitro'];
            $sanPham->id_donvitaitro = $validated['sanpham']['conhantaitro'] == true && !empty($validated['sanpham']['donvi']['id_donvi']) ? $validated['sanpham']['donvi']['id_donvi'] : null;
            $sanPham->chitietdonvitaitro = $validated['sanpham']['conhantaitro'] == true ? $validated['sanpham']['chitietdonvitaitro'] : null;
            $sanPham->thoidiemcongbohoanthanh = $validated['sanpham']['thoidiemcongbohoanthanh'];
            $sanPham->save();

            // update bai bao
            $baiBao->doi = $validated['doi'];
            $baiBao->url = $validated['url'];
            $baiBao->received = $validated['received'];
            $baiBao->accepted = $validated['accepted'];
            $baiBao->published = $validated['published'];
            $baiBao->abstract = $validated['abstract'];
            $baiBao->id_tapchi = $validated['tapchi']['id_tapchi'];
            $baiBao->volume = $validated['volume'];
            $baiBao->issue = $validated['issue'];
            $baiBao->number = $validated['number'];
            $baiBao->pages = $validated['pages'];
            $baiBao->save();
            $listIdKeyword = [];
            if ($listKeyword != null) {
                foreach ($validated['keywords'] as $keyword) {
                    $listIdKeyword[] = $keyword['id_keyword'];
                }
            }
            $baiBao->keyWords()->sync($listIdKeyword);
        });
        return new ResponseSuccess("Cập nhật bài báo thành công", true);
    }
}
