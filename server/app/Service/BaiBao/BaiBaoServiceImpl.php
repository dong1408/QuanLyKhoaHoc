<?php

namespace App\Service\BaiBao;

use App\Exceptions\BaiBao\BaiBaoKhoaHocNotFoundException;
use App\Exceptions\BaiBao\BaiBaoNotHaveFirstAuthor;
use App\Exceptions\BaiBao\RoleOnlyHeldByOnePersonException;
use App\Exceptions\BaiBao\TwoRoleSimilarForOnePersonException;
use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\InvalidValueException;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamRequest;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaiBaoServiceImpl implements BaiBaoService
{
    public function getDMSanPham()
    {
    }



    public function getBaiBaoPaging(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $isLock = $request->query('isLock', 0);

        $sanPhams = null;
        if ($isLock == 1) {
            $sanPhams = SanPham::onlyTrashed()->where(function ($query) use ($keysearch) {
                $query->where('tensanpham', 'LIKE', '%' . $keysearch . '%');
            })->where(function ($query) {
                $query->where('trangthairasoat', 'Đã xác nhận');
            })->orderBy($sortby)->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        } else { // Lấy những bản ghi not softdelete
            $sanPhams = SanPham::where(function ($query) use ($keysearch) {
                $query->where('tensanpham', 'LIKE', '%' . $keysearch . '%');
            })->where(function ($query) {
                $query->where('trangthairasoat', 'Đã xác nhận');
            })->orderBy($sortby)->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        }
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham->baiBao);
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
        // $sanPhams = SanPham::where('trangthairasoat', 'Đang rà soát')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $sanPhams = SanPham::withTrashed()->where(function ($query) use ($keysearch) {
            $query->where('tensanpham', 'LIKE', '%' . $keysearch . '%')
                ->orWhere();
        })->where(function ($query) {
            $query->where('trangthairasoat', 'Đang rà soát');
        })->orderBy($sortby)->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
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
        DB::transaction(function () use ($validated, &$baiBao) {
            $tacGias = $validated['sanphamtacgia']['tacgias'];
            $vaiTros = $validated['sanphamtacgia']['vaitros'];
            $thuTus = $validated['sanphamtacgia']['thutu'];
            $tyLeDongGops = $validated['sanphamtacgia']['tyledonggop'];

            // Kiểm tra bài báo phải có tác giả đầu tiên
            if (array_search(1, $vaiTros) == null) {
                throw new BaiBaoNotHaveFirstAuthor();
            }

            // kiểm tra 1 người có 2 vai trò giống nhau trong bài báo
            for ($i = 0; $i < count($tacGias) - 1; $i++) {
                for ($z = $i + 1; $z < count($vaiTros); $z++) {
                    if (($tacGias[$i] == $tacGias[$z]) && ($vaiTros[$i] == $vaiTros[$z])) {
                        throw new TwoRoleSimilarForOnePersonException();
                    }
                }
            }

            // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
            if ((isset(array_count_values($vaiTros)[2]) && array_count_values($vaiTros)[2] >= 2) || (isset(array_count_values($vaiTros)[1]) && array_count_values($vaiTros)[1] >= 2)) {
                throw new RoleOnlyHeldByOnePersonException();
            }

            // Thực hiên insert khi không còn lỗi
            $sanPham = SanPham::create([
                'tensanpham' => $validated['sanpham']['tensanpham'],
                'id_loaisanpham' => $validated['sanpham']['id_loaisanpham'],
                'tongsotacgia' => $validated['sanpham']['tongsotacgia'],
                'solandaquydoi' => $validated['sanpham']['solandaquydoi'],
                'cosudungemailtruong' => $validated['sanpham']['cosudungemailtruong'],
                'cosudungemaildonvikhac' => $validated['sanpham']['cosudungemaildonvikhac'],
                'cothongtintruong' => $validated['sanpham']['cothongtintruong'],
                'cothongtindonvikhac' => $validated['sanpham']['cothongtindonvikhac'],
                'id_thongtinnoikhac' =>  $validated['sanpham']['id_thongtinnoikhac'],
                'conhantaitro' => $validated['sanpham']['conhantaitro'],
                'id_donvitaitro' => $validated['sanpham']['id_donvitaitro'],
                'ngaykekhai' => $validated['sanpham']['ngaykekhai'],
                'id_nguoikekhai' => $validated['sanpham']['id_nguoikekhai'],
                'trangthairasoat' => $validated['sanpham']['trangthairasoat'],
                'ngayrasoat' => $validated['sanpham']['ngayrasoat'],
                'id_nguoirasoat' => auth('api')->user()->id,
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
            // Kiểm tra nếu bài báo này kh có tác giả nào đảm nhiệm vai trò tác giả liên hệ
            // (có id =2) thì set vai trò đó cho người có vai trò tác giả đứng đầu (có id =1) 
            if (!in_array(2, $vaiTros)) {
                $key = array_search(1, $vaiTros);
                $vaiTros[] = 2;
                $tacGias[] = $tacGias[$key];
            }
            for ($i = 0; $i < count($tacGias); $i++) {
                $tacGiaId = $tacGias[$i];
                $vaiTroId = $vaiTros[$i];
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
        $result = Convert::getBaiBaoKhoaHocVm($baiBao);
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
        $sanPham->id_loaisanpham = $validated['id_loaisanpham'];
        $sanPham->tongsotacgia = $validated['tongsotacgia'];
        $sanPham->solandaquydoi = $validated['solandaquydoi'];
        $sanPham->cosudungemailtruong = $validated['cosudungemailtruong'];
        $sanPham->cosudungemaildonvikhac = $validated['cosudungemaildonvikhac'];
        $sanPham->cothongtintruong = $validated['cothongtintruong'];
        $sanPham->cothongtindonvikhac = $validated['cothongtindonvikhac'];
        $sanPham->id_thongtinnoikhac =  $validated['id_thongtinnoikhac'];
        $sanPham->conhantaitro = $validated['conhantaitro'];
        $sanPham->id_donvitaitro = $validated['id_donvitaitro'];
        $sanPham->ngaykekhai = $validated['ngaykekhai'];
        $sanPham->id_nguoikekhai = $validated['id_nguoikekhai'];
        $sanPham->trangthairasoat = $validated['trangthairasoat'];
        $sanPham->ngayrasoat = $validated['ngayrasoat'];
        $sanPham->id_nguoirasoat = $validated['id_nguoirasoat'];
        $sanPham->diemquydoi = $validated['diemquydoi'];
        $sanPham->gioquydoi = $validated['gioquydoi'];
        $sanPham->thongtinchitiet = $validated['thongtinchitiet'];
        $sanPham->capsanpham = $validated['capsanpham'];
        $sanPham->thoidiemcongbohoanthanh = $validated['thoidiemcongbohoanthanh'];
        $sanPham->save();
        $result = Convert::getSanPhamVm($sanPham);
        return new ResponseSuccess($result, 200);
    }



    public function updateBaiBao(UpdateBaiBaoRequest $request, int $id): ResponseSuccess
    {
        $id_sanpham = (int) $id;

        if (!is_int($id_sanpham)) {
            throw new InvalidValueException();
        }

        $baiBao = BaiBaoKhoaHoc::withTrashed()->where('id_sanpham', $id_sanpham)->first();
        if ($baiBao == null) {
            throw new BaiBaoKhoaHocNotFoundException();
        }
        $validated = $request->validated();
        DB::transaction(function () use ($validated, &$baiBao) {
            $tacGias = $validated['sanphamtacgia']['tacgias'];
            $vaiTros = $validated['sanphamtacgia']['vaitros'];
            $thuTus = $validated['sanphamtacgia']['thutu'];
            $tyLeDongGops = $validated['sanphamtacgia']['tyledonggop'];
            // Kiểm tra bài báo phải có tác giả đầu tiên
            if (array_search(1, $vaiTros) == null) {
                throw new BaiBaoNotHaveFirstAuthor();
            }
            // kiểm tra 1 người có 2 vai trò giống nhau trong bài báo
            for ($i = 0; $i < count($tacGias) - 1; $i++) {
                for ($z = $i + 1; $z < count($vaiTros); $z++) {
                    if (($tacGias[$i] == $tacGias[$z]) && ($vaiTros[$i] == $vaiTros[$z])) {
                        throw new TwoRoleSimilarForOnePersonException();
                    }
                }
            }
            // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
            if ((isset(array_count_values($vaiTros)[2]) && array_count_values($vaiTros)[2] >= 2) || (isset(array_count_values($vaiTros)[1]) && array_count_values($vaiTros)[1] >= 2)) {
                throw new RoleOnlyHeldByOnePersonException();
            }
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
            // Kiểm tra nếu bài báo này kh có tác giả nào đảm nhiệm vai trò tác giả liên hệ
            // (có id =2) thì set vai trò đó cho người có vai trò tác giả đứng đầu (có id =1) 
            if (!in_array(2, $vaiTros)) {
                $key = array_search(1, $vaiTros);
                $vaiTros[] = 2;
                $tacGias[] = $tacGias[$key];
            }
            SanPhamTacGia::where('id_sanpham', $baiBao->id_sanpham)->forceDelete();
            for ($i = 0; $i < count($tacGias); $i++) {
                $tacGiaId = $tacGias[$i];
                $vaiTroId = $vaiTros[$i];
                $thuTu = isset($thuTus[$i]) ? $thuTus[$i] : null;
                $tyLeDongGop = isset($tyLeDongGops[$i]) ? $tyLeDongGops[$i] : null;
                SanPhamTacGia::create([
                    'id_sanpham' => $baiBao->id_sanpham,
                    'id_tacgia' => $tacGiaId,
                    'id_vaitrotacgia' => $vaiTroId,
                    'thutu' => $thuTu,
                    'tyledonggop' => $tyLeDongGop
                ]);
            }
        });
        $result = Convert::getBaiBaoKhoaHocVm($baiBao);
        return new ResponseSuccess("Thành công", $result);
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
        return new ResponseSuccess("Thành công", "");
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
        return new ResponseSuccess("Thành công", "");
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
        return new ResponseSuccess("Thành công", "");
    }


    public function updateBaiBaoDong(CreateBaiBaoRequest $request, int $id)
    {
    }
}
