<?php

namespace App\Service\DeTai;

use App\Exceptions\BaiBao\BaiBaoNotHaveFirstAuthor;
use App\Exceptions\BaiBao\CreateBaiBaoFailedException;
use App\Exceptions\BaiBao\RoleOnlyHeldByOnePersonException;
use App\Exceptions\BaiBao\TwoRoleSimilarForOnePersonException;
use App\Exceptions\BaiBao\VaiTroOfBaiBaoException;
use App\Exceptions\DeTai\DeTaiCanNotUpdateException;
use App\Exceptions\DeTai\DeTaiNotFoundException;
use App\Exceptions\DeTai\VaiTroOfDeTaiException;
use App\Exceptions\InvalidValueException;
use App\Exceptions\SanPham\FileMinhChungNotFoundException;
use App\Exceptions\SanPham\LoaiSanPhamWrongException;
use App\Exceptions\SanPham\UpdateTrangThaiRaSoatException;
use App\Http\Requests\Detai\BaoCaoTienDoDeTaiRequest;
use App\Http\Requests\Detai\CreateDeTaiRequest;
use App\Http\Requests\Detai\NghiemThuDeTaiRequest;
use App\Http\Requests\Detai\TuyenChonDeTaiRequest;
use App\Http\Requests\Detai\UpdateDeTaiRequest;
use App\Http\Requests\Detai\XetDuyetDeTaiRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Models\DeTai\DeTai;
use App\Models\FileMinhChungSanPham;
use App\Models\SanPham\DMSanPham;
use App\Models\SanPham\DMVaiTroTacGia;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\User;
use App\Service\DeTai\DeTaiService;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;
use Illuminate\Support\Facades\DB;

class DeTaiServiceImple implements DeTaiService
{
    public function getDeTaiPaging(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }


    public function createDeTai(CreateDeTaiRequest $request): ResponseSuccess
    {
        $validated = $request->validated();

        $deTai = new DeTai();
        $sanPham = new SanPham();

        DB::transaction(function () use ($validated, &$deTai, &$sanPham) {
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
                if (DMVaiTroTacGia::where([['role', '=', 'detai'], ['id', '=', $newListSanPhamTacGia[$i]['id_vaitro']]])->first() == null) {
                    throw new VaiTroOfDeTaiException();
                }
                $listIdTacGia[] = $newListSanPhamTacGia[$i]['id_tacgia'];
                $listIdVaiTro[] = $newListSanPhamTacGia[$i]['id_vaitro'];
                $thuTus[] = $newListSanPhamTacGia[$i]['thutu'] == null ? null : $newListSanPhamTacGia[$i]['thutu'];
                $tyLeDongGops[] = $newListSanPhamTacGia[$i]['tyledonggop'] == null ? null : $newListSanPhamTacGia[$i]['tyledonggop'];
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

            $dmSanPhamBaiBao = DMSanPham::where('masanpham', 'detai')->first();
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

            $deTai = DeTai::create([
                'id_sanpham' => $sanPham->id,
                'maso' => $validated['maso'],
                'ngoaitruong' => $validated['ngoaitruong'],
                'truongchutri' => $validated['ngoaitruong'] == true ?  $validated['truongchutri'] : null,
                'id_tochucchuquan' => $validated['ngoaitruong'] == true ? $validated['id_tochucchuquan'] : null,
                'id_loaidetai' => $validated['ngoaitruong'] == false ? $validated['id_loaidetai'] : null,
                'detaihoptac' => $validated['detaihoptac'],
                'id_tochuchoptac' => $validated['detaihoptac'] == true ? $validated['id_tochuchoptac'] : null,
                'tylekinhphidonvihoptac' => $validated['detaihoptac'] == true ?  $validated['tylekinhphidonvihoptac'] : null,
                'capdetai' => $validated['capdetai'],
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

        $result = Convert::getDeTaiVm($sanPham);
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
            throw new DeTaiNotFoundException();
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
        // Check san pham bài báo trong trạng thái softDelete thì không cho chỉnh sửa
        if ($deTai->sanPham == null) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đúng loại sản phẩm là đề tài
        if ($deTai->sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
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
            throw new DeTaiNotFoundException();
        }
        // Check san pham trong trang thai softDelete thi khong cho chinh sua
        if ($sanPham->trashed()) {
            throw new DeTaiCanNotUpdateException();
        }

        // check đúng loại sản phẩm là đề tài
        if ($sanPham->dmSanPham->masanpham != 'baibaokhoahoc') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
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
                if (DMVaiTroTacGia::where([['role', '=', 'detai'], ['id', '=', $newListSanPhamTacGia[$i]['id_vaitro']]])->first() == null) {
                    throw new VaiTroOfDeTaiException();
                }
                $listIdTacGia[] = $newListSanPhamTacGia[$i]['id_tacgia'];
                $listIdVaiTro[] = $newListSanPhamTacGia[$i]['id_vaitro'];
                $thuTus[] = $newListSanPhamTacGia[$i]['thutu'] == null ? null : $newListSanPhamTacGia[$i]['thutu'];
                $tyLeDongGops[] = $newListSanPhamTacGia[$i]['tyledonggop'] == null ? null : $newListSanPhamTacGia[$i]['tyledonggop'];
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
            throw new DeTaiCanNotUpdateException();
        }

        // check đúng loại sản phẩm là đề tài
        if ($fileMinhChung->sanPham->dmSanPham->masanpham != 'detai') {
            throw new LoaiSanPhamWrongException("Sản phẩm không phải đề tài");
        }

        $validated = $request->validated();
        $fileMinhChung->loaiminhchung = $validated['loaiminhchung'];
        $fileMinhChung->url = $validated['url'];
        $fileMinhChung->save();
        $result = Convert::getFileMinhChungSanPhamVm($fileMinhChung);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTrangThaiRaSoatBaiBao(UpdateTrangThaiRaSoatRequest $request, int $id): ResponseSuccess
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
        $sanPham->ngayrasoat = date("Y-m-d H:i:s");
        $sanPham->save();
        return new ResponseSuccess("Thành công", true);
    }

    public function tuyenChonDeTai(TuyenChonDeTaiRequest $request, int $id): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }



    public function xetDuyetDeTai(XetDuyetDeTaiRequest $request, int $id): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }



    public function baoCaoTienDoDeTai(BaoCaoTienDoDeTaiRequest $request, int $id): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }


    public function nghiemThuDeTai(NghiemThuDeTaiRequest $request, int $id): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }


    public function getPhanLoaiDeTai(): ResponseSuccess
    {
        $result = [];
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
}
