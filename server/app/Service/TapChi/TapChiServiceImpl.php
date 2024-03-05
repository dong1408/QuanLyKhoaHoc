<?php

namespace App\Service\TapChi;

use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\NhaXuatBan\NhaXuatBanNotFoundException;
use App\Exceptions\QuyDoi\ChuyenNganhTinhDiemNotFoundException;
use App\Exceptions\QuyDoi\NganhTinhDiemNotFoundException;
use App\Exceptions\TapChi\NganhTheoHDGSNotFoundException;
use App\Exceptions\TapChi\PhanLoaiTapChiNotFoundException;
use App\Exceptions\TapChi\TapChiNotFoundException;
use App\Exceptions\TapChi\UpdateKhongCongNhanException;
use App\Exceptions\ToChuc\DonViChuQuanNotFoundException;
use App\Exceptions\UserInfo\QuocGiaNotFoundException;
use App\Exceptions\UserInfo\TinhThanhNotFoundException;
use App\Models\NhaXuatBan\NhaXuatBan;
use App\Models\QuyDoi\DMChuyenNganhTinhDiem;
use App\Models\QuyDoi\DMNganhTinhDiem;
use App\Models\TapChi\DMNganhTheoHDGS;
use App\Models\TapChi\DMPhanLoaiTapChi;
use App\Models\TapChi\TapChi;
use App\Models\TapChi\TapChiKhongCongNhan;
use App\Models\TapChi\TinhDiemTapChi;
use App\Models\TapChi\XepHangTapChi;
use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMTinhThanh;
use App\Models\UserInfo\DMToChuc;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Global_;

class TapChiServiceImpl implements TapChiService
{
    public function getAllTapChi(): ResponseSuccess
    {
        $result = [];
        $tapChis = TapChi::where('trangthai', true)->get();
        foreach ($tapChis as $tapChi) {
            $result[] = Convert::getTapChiVm($tapChi);
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getAllTapChiChoDuyet(): ResponseSuccess
    {
        $result = [];
        $tapChis = TapChi::where('trangthai', true)->get();
        foreach ($tapChis as $tapChi) {
            $result[] = Convert::getTapChiVm($tapChi);
        }
        return new ResponseSuccess("Thành công", $result);
    }


    public function getTapChiPaging(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $isLock = $request->query('isLock', 0);

        $tapChis = null;
        if ($isLock == 1) {
            $tapChis = TapChi::onlyTrashed()->where(function ($query) use ($keysearch) {
                $query->where('name', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('issn', 'LIKE', '%' . $keysearch . '%');
            })->where(function ($query) {
                $query->where('trangthai', true);
            })->orderBy($sortby)->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        } else { // Lấy những bản ghi not softdelete
            $tapChis = TapChi::where(function ($query) use ($keysearch) {
                $query->where('name', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('issn', 'LIKE', '%' . $keysearch . '%');
            })->where(function ($query) {
                $query->where('trangthai', true);
            })->orderBy($sortby)->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        }
        $result = [];
        foreach ($tapChis as $tapChi) {
            $result[] = Convert::getTapChiVm($tapChi);
        }
        $pagingResponse = new PagingResponse($tapChis->lastPage(),  $tapChis->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }

    public function getTapChiById(int $id): ResponseSuccess
    {
        $id = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }

    public function getDetailTapChi(int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $result = Convert::getTapChiDetailVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function getLichSuTapChiKhongCongNhan(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $page = $request->request('page',1);

        $result = [];
        $tapChiKhongCongNhans = TapChiKhongCongNhan::withTrashed()
        ->where('id_tapchi', $id_tapchi)
            ->orderBy('created_at', 'desc')
            ->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($tapChiKhongCongNhans as $tapChiKhongCongNhan) {
            $result[] = Convert::getTapChiKhongCongNhanVm($tapChiKhongCongNhan);
        }
        $pagingResponse = new PagingResponse($tapChiKhongCongNhans->lastPage(), $tapChiKhongCongNhans->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getLichSuXepHangTapChi(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $page = $request->request('page',1);

        $result = [];
        $xepHangTapChis = XepHangTapChi::withTrashed()->where('id_tapchi', '=', $id_tapchi)
            ->orderBy('created_at', 'desc')
            ->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($xepHangTapChis as $xepHangTapChi) {
            $result[] = Convert::getXepHangTapChiVm($xepHangTapChi);
        }
        $pagingResponse = new PagingResponse($xepHangTapChis->lastPage(), $xepHangTapChis->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getLichSuTinhDiemTapChi(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $page = $request->request('page',1);

        $result = [];
        $tinhDiemTapChis = TinhDiemTapChi::withTrashed()->where('id_tapchi', '=', $id_tapchi)->orderBy('created_at', 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($tinhDiemTapChis as $tinhDiemTapChi) {
            $result[] = Convert::getTinhDIemTapChiVm($tinhDiemTapChi);
        }
        $pagingResponse = new PagingResponse($tinhDiemTapChis->lastPage(), $tinhDiemTapChis->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function createTapChi(Request $request): ResponseSuccess
    {
        if (!empty($request->id_nhaxuatban) && !NhaXuatBan::find($request->id_nhaxuatban)) {
            throw new NhaXuatBanNotFoundException();
        }
        if (!empty($request->id_donvichuquan) && !DMToChuc::find($request->id_donvichuquan)) {
            throw new DonViChuQuanNotFoundException();
        }
        if (!empty($request->id_address_city) && !DMTinhThanh::find($request->id_address_city)) {
            throw new TinhThanhNotFoundException();
        }
        if (!empty($request->id_address_country) && !DMQuocGia::find($request->id_address_country)) {
            throw new QuocGiaNotFoundException();
        }
        if (!empty($request->tinhdiemtapchi['id_nganhtinhdiem']) && !DMNganhTinhDiem::find($request->tinhdiemtapchi['id_nganhtinhdiem'])) {
            throw new NganhTinhDiemNotFoundException();
        }
        if (!empty($request->tinhdiemtapchi['id_chuyennganhtinhdiem']) && !DMChuyenNganhTinhDiem::find($request->tinhdiemtapchi['id_chuyennganhtinhdiem'])) {
            throw new ChuyenNganhTinhDiemNotFoundException();
        }
        if (!empty($request->dmphanloaitapchi) && !collect($request->dmphanloaitapchi)->diff(DMPhanLoaiTapChi::whereIn('id', $request->dmphanloaitapchi)->get()->pluck('id')->all())->isEmpty()) {
            throw new PhanLoaiTapChiNotFoundException();
        }
        if (!empty($request->dmnganhtheohdgs) && !collect($request->dmnganhtheohdgs)->diff(DMNganhTheoHDGS::whereIn('id', $request->dmnganhtheohdgs)->get()->pluck('id')->all())->isEmpty()) {
            throw new NganhTheoHDGSNotFoundException();
        }

        $request->validate([
            "name" => "bail|required|unique:tap_chis,name",
            "issn" => "bail|nullable|string",
            "eissn" => "bail|nullable|string",
            "pissn" => "bail|nullable|string",
            "website" => "bail|nullable|url",
            "quocte" => "bail|nullable|boolean",
            "id_nhaxuatban" => "bail|nullable|integer",
            "id_donvichuquan" => "bail|nullable|integer",
            "address" => "bail|nullable|string",
            "id_address_city" => "bail|nullable|integer",
            "id_address_country" => "bail|nullable|integer",
            "trangthai" => "bail|nullable|boolean",

            "tapchikhongcongnhan.khongduoccongnhan" => "bail|nullable|boolean",
            "tapchikhongcongnhan.ghichu" => "bail|nullable|string",

            "xephangtapchi.wos" => "bail|nullable|string",
            "xephangtapchi.if" => "bail|nullable|string",
            "xephangtapchi.quartile" => "bail|nullable|string",
            "xephangtapchi.abs" => "bail|nullable|string",
            "xephangtapchi.abcd" => "bail|nullable|string",
            "xephangtapchi.aci" => "bail|nullable|string",
            "xephangtapchi.ghichu" => "bail|nullable|string",

            "tinhdiemtapchi.id_nganhtinhdiem" => "bail|required|integer",
            "tinhdiemtapchi.id_chuyennganhtinhdiem" => "bail|required|integer",
            "tinhdiemtapchi.diem" => "bail|nullable|string",
            "tinhdiemtapchi.namtinhdiem" => "bail|nullable|string",
            "tinhdiemtapchi.ghichu" => "bail|nullable|string",

            "dmphanloaitapchi" => "bail|nullable|array",
            'dmnganhtheohdgs' => "bail|nullable|array",
        ], [
            // "tapchikhongcongnhan.khongduoccongnhan.required" => "yeu cau kh dc bo trong"
            // "tapchikhongcongnhan.khongduoccongnhan.required.boolean" => ""
        ]);
        $tapChi = new TapChi();
        DB::transaction(function () use ($request, &$tapChi) {
            $tapChi = TapChi::create([
                'name' => $request->name,
                'issn' => $request->issn,
                'eissn' => $request->eissn,
                'pissn' => $request->pissn,
                'website' => $request->website,
                'quocte' => $request->quocte,
                'id_nhaxuatban' => $request->id_nhaxuatban,
                'id_donvichuquan' => $request->id_donvichuquan,
                'address' => $request->address,
                'id_address_city' => $request->id_address_city,
                'id_address_country' => $request->id_address_country,
                'trangthai' => $request->trangthai,
                'id_nguoithem' => auth('api')->user()->id,
            ]);
            TapChiKhongCongNhan::create([
                'id_tapchi' => $tapChi->id,
                'khongduoccongnhan' => $request->tapchikhongcongnhan['khongduoccongnhan'],
                'ghichu' => $request->tapchikhongcongnhan['ghichu'],
                'id_nguoicapnhat' => auth('api')->user()->id,
            ]);
            XepHangTapChi::create([
                'id_tapchi' => $tapChi->id,
                'wos' => $request->xephangtapchi['wos'],
                'if' => $request->xephangtapchi['if'],
                'quartile' => $request->xephangtapchi['quartile'],
                'abs' => $request->xephangtapchi['abs'],
                'abcd' => $request->xephangtapchi['abcd'],
                'aci' => $request->xephangtapchi['aci'],
                'ghichu' => $request->xephangtapchi['ghichu'],
                'id_user' => auth('api')->user()->id
            ]);
            TinhDiemTapChi::create([
                'id_tapchi' => $tapChi->id,
                'id_chuyennganhtinhdiem' => $request->tinhdiemtapchi['id_chuyennganhtinhdiem'],
                'id_nganhtinhdiem' => $request->tinhdiemtapchi['id_nganhtinhdiem'],
                'diem' => $request->tinhdiemtapchi['diem'],
                'namtinhdiem' => $request->tinhdiemtapchi['namtinhdiem'],
                'id_nguoicapnhat' => auth('api')->user()->id,
                'ghichu' => $request->tinhdiemtapchi['ghichu']
            ]);
            $tapChi->dmPhanLoaiTapChis()->attach($request->dmphanloaitapchi);
            $tapChi->dmNganhTheoHDGS()->attach($request->dmnganhtheohdgs);
        });
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTrangThaiTapChi(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $request->validate([
            "trangthai" => "required|boolean"
        ]);
        $tapChi->trangthai = $request->trangthai;
        $tapChi->save();
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTapChi(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        if (!empty($request->id_nhaxuatban) && !NhaXuatBan::find($request->id_nhaxuatban)) {
            throw new NhaXuatBanNotFoundException();
        }
        if (!empty($request->id_donvichuquan) && !DMToChuc::find($request->id_donvichuquan)) {
            throw new DonViChuQuanNotFoundException();
        }
        if (!empty($request->id_address_city) && !DMTinhThanh::find($request->id_address_city)) {
            throw new TinhThanhNotFoundException();
        }
        if (!empty($request->id_address_country) && !DMQuocGia::find($request->id_address_country)) {
            throw new QuocGiaNotFoundException();
        }
        if (!empty($request->dmphanloaitapchi) && !collect($request->dmphanloaitapchi)->diff(DMPhanLoaiTapChi::whereIn('id', $request->dmphanloaitapchi)->get()->pluck('id')->all())->isEmpty()) {
            throw new PhanLoaiTapChiNotFoundException();
        }
        if (!empty($request->dmnganhtheohdgs) && !collect($request->dmnganhtheohdgs)->diff(DMNganhTheoHDGS::whereIn('id', $request->dmnganhtheohdgs)->get()->pluck('id')->all())->isEmpty()) {
            throw new NganhTheoHDGSNotFoundException();
        }

        $uniqueNameRule = $tapChi->name === $request->name ? '' : '|unique:tap_chis,name';
        $request->validate([
            "name" => "bail|required|" . $uniqueNameRule,
            "issn" => "bail|nullable|string",
            "eissn" => "bail|nullable|string",
            "pissn" => "bail|nullable|string",
            "website" => "bail|nullable|url",
            "quocte" => "bail|nullable|boolean",
            "id_nhaxuatban" => "bail|nullable|integer",
            "id_donvichuquan" => "bail|nullable|integer",
            "address" => "bail|nullable|string",
            "id_address_city" => "bail|nullable|integer",
            "id_address_country" => "bail|nullable|integer",

            "dmphanloaitapchi" => "bail|nullable|array",
            "dmnganhtheohdgs" => "bail|nullable|array"
        ]);
        DB::transaction(function () use ($request, &$tapChi) {
            $tapChi->name = $request->name;
            $tapChi->issn = $request->issn;
            $tapChi->eissn = $request->eissn;
            $tapChi->pissn = $request->pissn;
            $tapChi->website = $request->website;
            $tapChi->quocte = $request->quocte;
            $tapChi->id_nhaxuatban = $request->id_nhaxuatban;
            $tapChi->id_donvichuquan = $request->id_donvichuquan;
            $tapChi->address = $request->address;
            $tapChi->id_address_city = $request->id_address_city;
            $tapChi->id_address_country = $request->id_address_country;
            $tapChi->id_nguoithem = auth('api')->user()->id;
            $tapChi->save();
            $tapChi->dmPhanLoaiTapChis()->sync($request->dmphanloaitapchi);
            $tapChi->dmNganhTheoHDGS()->sync($request->dmnganhtheohdgs);
        });
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateKhongCongNhanTapChi(Request $request, int $id): ResponseSuccess
    {
        $request->validate([
            "khongduoccongnhan" => "bail|nullable|boolean",
            "ghichu" => "bail|nullable|string",
        ]);

        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        if($tapChi->khongduoccongnhan == $request->khongduoccongnhan){
            throw new UpdateKhongCongNhanException();
        }
    
        $tapChiKhongCongNhan = TapChiKhongCongNhan::create([
            'id_tapchi' => $tapChi->id,
            'khongduoccongnhan' => $request->khongduoccongnhan,
            'ghichu' => $request->ghichu,
            'id_nguoicapnhat' => auth('api')->user()->id,
        ]);
        $result = Convert::getTapChiKhongCongNhanVm($tapChiKhongCongNhan);
        return new ResponseSuccess("Thành công", $result);
    }

    public function updateXepHangTapChi(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $request->validate([
            "wos" => "bail|nullable|string",
            "if" => "bail|nullable|string",
            "quartile" => "bail|nullable|string",
            "abs" => "bail|nullable|string",
            "abcd" => "bail|nullable|string",
            "aci" => "bail|nullable|string",
            "ghichu" => "bail|nullable|string",
        ]);
        $xepHangTapChi = XepHangTapChi::create([
            'id_tapchi' => $tapChi->id,
            'wos' => $request->wos,
            'if' => $request->if,
            'quartile' => $request->quartile,
            'abs' => $request->abs,
            'abcd' => $request->abcd,
            'aci' => $request->aci,
            'ghichu' => $request->ghichu,
            'id_user' => auth('api')->user()->id,
        ]);
        $result = Convert::getXepHangTapChiVm($xepHangTapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTinhDiemTapChi(Request $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        if (!empty($request->id_nganhtinhdiem) && !DMNganhTinhDiem::find($request->id_nganhtinhdiem)) {
            throw new NganhTinhDiemNotFoundException();
        }
        if (!empty($request->id_chuyennganhtinhdiem) && !DMChuyenNganhTinhDiem::find($request->id_chuyennganhtinhdiem)) {
            throw new ChuyenNganhTinhDiemNotFoundException();
        }
        $request->validate([
            "id_nganhtinhdiem" => "bail|required|integer",
            "id_chuyennganhtinhdiem" => "bail|required|integer",
            "diem" => "bail|nullable|string",
            "namtinhdiem" => "bail|nullable|string",
            "ghichu" => "bail|nullable|string",
        ]);
        $tinhDiemTapChi = TinhDiemTapChi::create([
            'id_tapchi' => $tapChi->id,
            'id_chuyennganhtinhdiem' => $request->id_chuyennganhtinhdiem,
            'id_nganhtinhdiem' => $request->id_nganhtinhdiem,
            'diem' => $request->diem,
            'namtinhdiem' => $request->namtinhdiem,
            'id_nguoicapnhat' => auth('api')->user()->id,
            'ghichu' => $request->ghichu
        ]);
        $result = Convert::getTinhDIemTapChiVm($tinhDiemTapChi);
        return new ResponseSuccess("Thành công", $result);
    }



    public function deleteTapChi(int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        if (!$tapChi->delete()) {
            throw new DeleteFailException();
        }
        return new ResponseSuccess("Thành công", "");
    }

    public function restoreTapChi(int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::onlyTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        TapChi::onlyTrashed()->where('id', $id_tapchi)->restore();
        return new ResponseSuccess("Thành công", "");
    }

    public function forceDeleteTapChi(int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        $tapChi = TapChi::onlyTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        TapChi::onlyTrashed()->where('id', $id_tapchi)->forceDelete();
        return new ResponseSuccess("Thành công", "");
    }
}
