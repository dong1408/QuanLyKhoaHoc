<?php

namespace App\Service\BaiBao;

use App\Exceptions\BaiBao\BaiBaoKhoaHocNotFoundException;
use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\InvalidValueException;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
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

    public function getBaiBaoPaging(Request $request)
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


    public function getBaiBaoChoDuyet(Request $request)
    {
        $page = $request->query('page', 1);
        $sanPhams = SanPham::where('trangthai', 'Đang rà soát')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        $result = [];
        foreach ($sanPhams as $sanPham) {
            $result[] = Convert::getBaiBaoKhoaHocVm($sanPham);
        }
        $pagingResponse = new PagingResponse($sanPhams->lastPage(), $sanPhams->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getDetailBaiBao(int $id)
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



    public function createBaiBao(CreateBaiBaoRequest $request)
    {
        $validated = $request->validated();
        $baiBao = new BaiBaoKhoaHoc();
        DB::transaction(function () use ($validated, &$baiBao) {
            $sanPham = SanPham::create([
                'tensanpham' => $validated['sanpham']['tensanpham'],
                'id_loaisanpham' => $validated['sanpham']['id_loaisanpham'],
                'tongsotacgia' => $validated['sanpham']['tongsotacgia'],
                'solanquydoi' => $validated['sanpham']['solanquydoi'],
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
            if (is_array($validated['sanphamtacgia']['tacgias']) && is_array($validated['sanphamtacgia']['tacgias'])) {
                $flag1 = false;
                $tacGias = $validated['sanphamtacgia']['tacgias'];
                $vaiTros = $validated['sanphamtacgia']['vaitros'];
                $thuTus = $validated['sanphamtacgia']['thutu'];
                $tyLeDongGops = $validated['sanphamtacgia']['tyledonggop'];

                // kiểm tra 1 người có 2 vai trò giống nhau trong bài báo
                for ($i = 0; $i < count($tacGias) - 1; $i++) {
                    for ($z = $i + 1; $z < count($vaiTros); $z++) {
                        if (($tacGias[$i] == $tacGias[$z]) && ($vaiTros[$i] == $vaiTros[$z])) {
                            $flag1 = true;
                            break;
                        }
                    }
                }

                // Kiểm tra những vai trò chỉ có 1 người đảm nhiểm
                // ...
                for ($i = 0; $i < count($vaiTros) -1; $i++) {
                    if($vaiTros[$i] == 1){
                        
                    }
                }
                // Thực hiên insert sanpham_tacgia khi không còn lỗi
                if (!$flag1) {
                    if (!in_array(2, $vaiTros)) {
                        $key = array_search(1, $vaiTros);
                        $vaiTros[] = $vaiTros[$key];
                        $tacGias[] = 2;
                    }
                    for ($i = 0; $i < count($tacGias); $i++) {
                        $tacGiaId = $tacGias[$i];
                        $vaiTroId = $vaiTros[$i];
                        $thuTu = $thuTus[$i];
                        $tyLeDongGop = $tyLeDongGops[$i];

                        SanPhamTacGia::create([
                            'id_sanpham' => 3,
                            'id_tacgia' => $tacGiaId,
                            'id_vaitrotacgia' => $vaiTroId,
                            'thutu' => $thuTu,
                            'tyledonggop' => $tyLeDongGop
                        ]);
                    }
                }
            }
        });
        $sanPham = SanPham::find(1);
        return response()->json($sanPham);
    }

    public function updateBaiBao()
    {
    }

    public function deleteBaiBao(int $id)
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


    public function restoreBaiBao(int $id)
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

    public function forceDeleteBaiBao(int $id)
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
}
