<?php

namespace App\Service\BaiBao;

use App\Exceptions\BaiBao\BaiBaoKhoaHocNotFoundException;
use App\Exceptions\BaiBao\BaiBaoNotHaveFirstAuthor;
use App\Exceptions\BaiBao\CreateBaiBaoFailedException;
use App\Exceptions\BaiBao\FileMinhChungNotFoundException;
use App\Exceptions\BaiBao\RoleOnlyHeldByOnePersonException;
use App\Exceptions\BaiBao\TwoRoleSimilarForOnePersonException;
use App\Exceptions\BaiBao\UpdateTrangThaiRaSoatException;
use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\InvalidValueException;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\BaiBao\UpdateTrangThaiRaSoatBaiBao;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\FileMinhChungSanPham;
use App\Models\SanPham\DMSanPham;
use App\Models\SanPham\DMVaiTroTacGia;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
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
        $page = $request->query('page', 1);
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
        $result = Convert::getBaiBaoKhoaHocDetailVm($sanPham->baiBao);
        return new ResponseSuccess("Thành công", $result);
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
            for ($i = 0; $i < count($listSanPhamTacGia); $i++) {
                $listIdTacGia[] = $listSanPhamTacGia[$i]['id_tacgia'];
                $listIdVaiTro[] = $listSanPhamTacGia[$i]['id_vaitro'];
                $thuTus[] = $listSanPhamTacGia[$i]['thutu'] == null ? null : $listSanPhamTacGia[$i]['thutu'];
                $tyLeDongGop[] = $listSanPhamTacGia[$i]['tyledonggop'] == null ? null : $listSanPhamTacGia[$i]['tyledonggop'];
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

            $sanPhamBaiBao = DMSanPham::where('masanpham','baibaokhoahoc')->first();
            if($sanPhamBaiBao == null){
                throw new CreateBaiBaoFailedException();
            }

            // Thực hiên insert khi không còn lỗi
            $sanPham = SanPham::create([
                'tensanpham' => $validated['sanpham']['tensanpham'],
                'id_loaisanpham' => $sanPhamBaiBao->id,
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
                'ngaykekhai' => $validated['sanpham']['ngaykekhai'],
                'id_nguoikekhai' => $validated['sanpham']['id_nguoikekhai'],
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
//        $sanPham->id_nguoikekhai = $validated['id_nguoikekhai'];
        $sanPham->diemquydoi = $validated['diemquydoi'];
        $sanPham->gioquydoi = $validated['gioquydoi'];
        $sanPham->thongtinchitiet = $validated['thongtinchitiet'];
        $sanPham->capsanpham = $validated['capsanpham'];
        $sanPham->thoidiemcongbohoanthanh = $validated['thoidiemcongbohoanthanh'];
        $sanPham->save();
        return new ResponseSuccess("Cập nhật thành công",true);
    }



    public function updateBaiBao(UpdateBaiBaoRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }
        $baiBao = BaiBaoKhoaHoc::where('id_sanpham', $id_sanpham)->first();
        if ($baiBao->sanPham == null || $baiBao == null) {
            throw new BaiBaoKhoaHocNotFoundException();
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
        $validated = $request->validated();

        $listIdTacGia = [];
        $listIdVaiTro = [];
        $thuTus = [];
        $tyLeDongGops = [];
        $listSanPhamTacGia = $validated['sanpham_tacgia'];
        for ($i = 0; $i < count($listSanPhamTacGia); $i++) {
            $listIdTacGia[] = $listSanPhamTacGia[$i]['id_tacgia'];
            $listIdVaiTro[] = $listSanPhamTacGia[$i]['id_vaitro'];
            $thuTus[] = $listSanPhamTacGia[$i]['thutu'] == null ? null : $listSanPhamTacGia[$i]['thutu'];
            $tyLeDongGop[] = $listSanPhamTacGia[$i]['tyledonggop'] == null ? null : $listSanPhamTacGia[$i]['tyledonggop'];
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
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;
        $fileMinhChung = FileMinhChungSanPham::where('id_sanpham', $id_sanpham)->first();
        if ($fileMinhChung == null) {
            throw new FileMinhChungNotFoundException();
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
        $sanPham = SanPham::find($id_sanpham);
        if ($sanPham == null) {
            throw new BaiBaoKhoaHocNotFoundException();
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
}
