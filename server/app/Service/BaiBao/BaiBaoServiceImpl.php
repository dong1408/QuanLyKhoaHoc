<?php

namespace App\Service\BaiBao;

use App\Exceptions\BaiBao\BaiBaoCanNotUpdateException;
use App\Exceptions\BaiBao\BaiBaoKhoaHocNotFoundException;
use App\Exceptions\BaiBao\BaiBaoNotHaveFirstAuthor;
use App\Exceptions\BaiBao\CreateBaiBaoFailedException;
use App\Exceptions\BaiBao\FileMinhChungNotFoundException;
use App\Exceptions\BaiBao\RoleOnlyHeldByOnePersonException;
use App\Exceptions\BaiBao\TwoRoleSimilarForOnePersonException;
use App\Exceptions\BaiBao\UpdateTrangThaiRaSoatException;
use App\Exceptions\BaiBao\VaiTroOfBaiBaoException;
use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\InvalidValueException;
use App\Exceptions\SanPham\LoaiSanPhamWrongException;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\BaiBao\UpdateTrangThaiRaSoatBaiBao;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\FileMinhChungSanPham;
use App\Models\SanPham\DMSanPham;
use App\Models\SanPham\DMVaiTroTacGia;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\User;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BaiBaoServiceImpl implements BaiBaoService
{

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
        } else { // Lấy những bản ghi not softdelete            
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
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        $result = Convert::getBaiBaoKhoaHocDetailVm($sanPham);
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

            $newListSanPhamTacGia = [];

            $filteredWithId = array_filter($listSanPhamTacGia, function ($object) {
                return !is_null($object['id_tacgia']);
            });
            $filteredWithoutId = array_filter($listSanPhamTacGia, function ($object) {
                return is_null($object['id_tacgia']);
            });
            if (count($filteredWithoutId) > 0) {
                $listObjectUnique = $this->filterUniqueAndDuplicates($filteredWithoutId, 'tentacgia');
                foreach ($listObjectUnique as  $item) {
                    $randomId = $this->randomUnique();
                    $user = User::create([
                        'username' => "sgu2024" . $randomId,
                        'password' => "sgu2024",
                        'name' => $item['tentacgia'],
                        'email' => "sgu2024" . $randomId . "@gmail.com"
                    ]);
                    $newData[] = [
                        'id_tacgia' => $user->id,
                        'id_vaitro' => $item['id_vaitro'],
                        'thutu' => $item['thutu'],
                        'tyledonggop' => $item['tyledonggop'],
                        'duplicates' => $item['duplicates'],
                    ];
                }
                foreach ($newData as $item) {
                    foreach ($item["duplicates"] as $duplicate) {
                        $filteredWithoutId[$duplicate]['id_tacgia'] = $item['id_tacgia'];
                    }
                }
                $newListSanPhamTacGia = array_merge($filteredWithId, $filteredWithoutId);
            } else {
                $newListSanPhamTacGia = $filteredWithId;
            }



            for ($i = 0; $i < count($newListSanPhamTacGia); $i++) {
                if (DMVaiTroTacGia::where([['role', '=', 'baibao'], ['id', '=', $newListSanPhamTacGia[$i]['id_vaitro']]])->first() == null) {
                    throw new VaiTroOfBaiBaoException();
                }
                $listIdTacGia[] = $newListSanPhamTacGia[$i]['id_tacgia'];
                $listIdVaiTro[] = $newListSanPhamTacGia[$i]['id_vaitro'];
                $thuTus[] = $newListSanPhamTacGia[$i]['thutu'] == null ? null : $newListSanPhamTacGia[$i]['thutu'];
                $tyLeDongGop[] = $newListSanPhamTacGia[$i]['tyledonggop'] == null ? null : $newListSanPhamTacGia[$i]['tyledonggop'];
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
                'solandaquydoi' => $validated['sanpham']['solandaquydoi'],
                'cosudungemailtruong' => $validated['sanpham']['cosudungemailtruong'],
                'cosudungemaildonvikhac' => $validated['sanpham']['cosudungemaildonvikhac'],
                'cothongtintruong' => $validated['sanpham']['cothongtintruong'],
                'cothongtindonvikhac' => $validated['sanpham']['cothongtindonvikhac'],
                'id_thongtinnoikhac' =>  $validated['sanpham']['cothongtindonvikhac'] == true ? $validated['sanpham']['id_thongtinnoikhac'] : null,
                'conhantaitro' => $validated['sanpham']['conhantaitro'],
                'id_donvitaitro' => $validated['sanpham']['conhantaitro'] == true ? $validated['sanpham']['id_donvitaitro'] : null,
                'chitietdonvitaitro' => $validated['sanpham']['conhantaitro'] == true ? $validated['sanpham']['chitietdonvitaitro'] : null,
                'ngaykekhai' => date("d-m-Y"),
                'id_nguoikekhai' => auth('api')->user()->id,
                'trangthairasoat' => "Đang rà soát",
                'ngayrasoat' => null,
                'id_nguoirasoat' => null,
                'diemquydoi' => $validated['sanpham']['diemquydoi'],
                'gioquydoi' => $validated['sanpham']['gioquydoi'],
                'thongtinchitiet' => $validated['sanpham']['thongtinchitiet'],
                'capsanpham' => $validated['sanpham']['capsanpham'],
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
                'keywords' => $validated['keywords'],
                'id_tapchi' => $validated['id_tapchi'],
                'volume' => $validated['volume'],
                'issue' => $validated['issue'],
                'number' => $validated['number'],
                'pages' => $validated['pages']
            ]);

            FileMinhChungSanPham::create([
                'id_sanpham' => $sanPham->id,
                'loaiminhchung' => $validated['fileminhchungsanpham']['loaiminhchung'],
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
        return new ResponseSuccess("Thành công", $result);
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

        // check đúng loại sản phẩm là bài báo khoa học
        if ($sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }

        $validated = $request->validated();

        $sanPham->tensanpham = $validated['tensanpham'];
        //        $sanPham->id_loaisanpham = $validated['id_loaisanpham'];
        $sanPham->tongsotacgia = $validated['tongsotacgia'];
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
        return new ResponseSuccess("Cập nhật thành công", true);
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

        // check đúng loại sản phẩm là bài báo khoa học
        if ($baiBao->sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }

        $validated = $request->validated();

        $baiBao->doi = $validated['doi'];
        $baiBao->url = $validated['url'];
        $baiBao->received = $validated['received'];
        $baiBao->accepted = $validated['accepted'];
        $baiBao->published = $validated['published'];
        $baiBao->abstract = $validated['abstract'];
        $baiBao->keywords = $validated['keywords'];
        $baiBao->id_tapchi = $validated['id_tapchi'];
        $baiBao->volume = $validated['volume'];
        $baiBao->issue = $validated['issue'];
        $baiBao->number = $validated['number'];
        $baiBao->pages = $validated['pages'];
        $baiBao->save();
        return new ResponseSuccess("Cập nhật thành công", true);
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



        DB::transaction(function () use ($validated, &$sanPham) {
            $listIdTacGia = [];
            $listIdVaiTro = [];
            $thuTus = [];
            $tyLeDongGops = [];
            $listSanPhamTacGia = $validated['sanpham_tacgia'];



            $newListSanPhamTacGia = [];

            $filteredWithId = array_filter($listSanPhamTacGia, function ($object) {
                return !is_null($object['id_tacgia']);
            });
            $filteredWithoutId = array_filter($listSanPhamTacGia, function ($object) {
                return is_null($object['id_tacgia']);
            });
            if (count($filteredWithoutId) > 0) {
                $listObjectUnique = $this->filterUniqueAndDuplicates($filteredWithoutId, 'tentacgia');
                foreach ($listObjectUnique as  $item) {
                    $randomId = $this->randomUnique();
                    $user = User::create([
                        'username' => "sgu2024" . $randomId,
                        'password' => "sgu2024",
                        'name' => $item['tentacgia'],
                        'email' => "sgu2024" . $randomId . "@gmail.com"
                    ]);
                    $newData[] = [
                        'id_tacgia' => $user->id,
                        'id_vaitro' => $item['id_vaitro'],
                        'thutu' => $item['thutu'],
                        'tyledonggop' => $item['tyledonggop'],
                        'duplicates' => $item['duplicates'],
                    ];
                }
                foreach ($newData as $item) {
                    foreach ($item["duplicates"] as $duplicate) {
                        $filteredWithoutId[$duplicate]['id_tacgia'] = $item['id_tacgia'];
                    }
                }
                $newListSanPhamTacGia = array_merge($filteredWithId, $filteredWithoutId);
            } else {
                $newListSanPhamTacGia = $filteredWithId;
            }




            for ($i = 0; $i < count($newListSanPhamTacGia); $i++) {
                if (DMVaiTroTacGia::where([['role', '=', 'baibao'], ['id', '=', $newListSanPhamTacGia[$i]['id_vaitro']]])->first() == null) {
                    throw new VaiTroOfBaiBaoException();
                }
                $listIdTacGia[] = $newListSanPhamTacGia[$i]['id_tacgia'];
                $listIdVaiTro[] = $newListSanPhamTacGia[$i]['id_vaitro'];
                $thuTus[] = $newListSanPhamTacGia[$i]['thutu'] == null ? null : $newListSanPhamTacGia[$i]['thutu'];
                $tyLeDongGop[] = $newListSanPhamTacGia[$i]['tyledonggop'] == null ? null : $newListSanPhamTacGia[$i]['tyledonggop'];
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
            $result = [];
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
        });
        return new ResponseSuccess("Thành công", true);
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

        // check đúng loại sản phẩm là bài báo khoa học
        if ($fileMinhChung->sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }

        $validated = $request->validated();
        $fileMinhChung->loaiminhchung = $validated['loaiminhchung'];
        $fileMinhChung->url = $validated['url'];
        $fileMinhChung->save();
        $result = Convert::getFileMinhChungSanPhamVm($fileMinhChung);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTrangThaiRaSoatBaiBao(UpdateTrangThaiRaSoatBaiBao $request, int $id): ResponseSuccess
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
        if($sanPham->dmSanPham->masanpham != 'baibaokhoahoc'){
            throw new LoaiSanPhamWrongException("Sản phẩm không phải bài báo khoa học");
        }

        $validated = $request->validated();
        if ($sanPham->trangthairasoat == $validated['trangthairasoat']) {
            throw new UpdateTrangThaiRaSoatException();
        }
        $sanPham->trangthairasoat = $validated['trangthairasoat'];
        $sanPham->id_nguoirasoat = auth('api')->user()->id;
        $sanPham->ngayrasoat = date("Y-m-d H:i:s");
        $sanPham->save();
        return new ResponseSuccess("Thành công", true);
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
        return new ResponseSuccess("Thành công", true);
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
        return new ResponseSuccess("Thành công", true);
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
        return new ResponseSuccess("Thành công", true);
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
}
