<?php

namespace App\Service\TapChi;

use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\InvalidValueException;
use App\Exceptions\TapChi\TapChiNotFoundException;
use App\Exceptions\TapChi\TinhDiemTapChiException;
use App\Exceptions\TapChi\UpdateKhongCongNhanException;
use App\Http\Requests\TapChi\CreateTapChiRequest;
use App\Http\Requests\TapChi\UpdateTapChiKhongCongNhanRequest;
use App\Http\Requests\TapChi\UpdateTapChiRequest;
use App\Http\Requests\TapChi\UpdateTinhDiemTapChiRequest;
use App\Http\Requests\TapChi\UpdateTrangThaiTapChiRequest;
use App\Http\Requests\TapChi\UpdateXepHangTapChiRequest;
use App\Models\TapChi\TapChi;
use App\Models\TapChi\TapChiKhongCongNhan;
use App\Models\TapChi\TinhDiemTapChi;
use App\Models\TapChi\XepHangTapChi;
use App\Models\QuyDoi\DMChuyenNganhTinhDiem;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TapChiServiceImpl implements TapChiService
{
    public function getAllTapChi(Request $request): ResponseSuccess
    {
        $keysearch = $request->query('search', "");
        $result = [];
        if (!empty($keysearch)) {
            $tapChis = TapChi::where('name', 'LIKE', '%' . $keysearch . '%')->where('trangthai', true)->take(10)->get();
            foreach ($tapChis as $tapChi) {
                $result[] = Convert::getTapChiVm($tapChi);
            }
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getAllTapChiChoDuyet(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");

        $tapChis = TapChi::where(function ($query) use ($keysearch) {
            $query->where('name', 'LIKE', '%' . $keysearch . '%')
                ->orWhere('issn', 'LIKE', '%' . $keysearch . '%')
                ->orWhere('pissn', 'LIKE', '%' . $keysearch . '%')
                ->orWhere('eissn', 'LIKE', '%' . $keysearch . '%');
        })->orderBy($sortby, 'desc')->where(function ($query) {
            $query->where('trangthai', false);
        })->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);

        $result = [];
        foreach ($tapChis as $tapChi) {
            $result[] = Convert::getTapChiVm($tapChi);
        }
        $pagingResponse = new PagingResponse($tapChis->lastPage(),  $tapChis->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
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
                    ->orWhere('issn', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('pissn', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('eissn', 'LIKE', '%' . $keysearch . '%');
            })->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        } else { // Lấy những bản ghi not softdelete
            $tapChis = TapChi::where(function ($query) use ($keysearch) {
                $query->where('name', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('issn', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('pissn', 'LIKE', '%' . $keysearch . '%')
                    ->orWhere('eissn', 'LIKE', '%' . $keysearch . '%');
            })->where(function ($query) {
                $query->where('trangthai', true)->orWhere('trangthai', null);
            })->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
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

        if (!is_int($id)) {
            throw new InvalidValueException();
        }

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

        if (!is_int($id_tapchi)) {
            throw new InvalidValueException();
        }

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

        if (!is_int($id_tapchi)) {
            throw new InvalidValueException();
        }

        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $page = $request->query('page', 1);

        $result = [];
        $tapChiKhongCongNhans = TapChiKhongCongNhan::where('id_tapchi', $id_tapchi)
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

        if (!is_int($id_tapchi)) {
            throw new InvalidValueException();
        }

        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $page = $request->query('page', 1);

        $result = [];
        $xepHangTapChis = XepHangTapChi::where('id_tapchi', '=', $id_tapchi)
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

        if (!is_int($id_tapchi)) {
            throw new InvalidValueException();
        }

        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $page = $request->query('page', 1);

        $result = [];
        $tinhDiemTapChis = TinhDiemTapChi::where('id_tapchi', '=', $id_tapchi)->orderBy('created_at', 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        foreach ($tinhDiemTapChis as $tinhDiemTapChi) {
            $result[] = Convert::getTinhDIemTapChiVm($tinhDiemTapChi);
        }
        $pagingResponse = new PagingResponse($tinhDiemTapChis->lastPage(), $tinhDiemTapChis->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function createTapChi(CreateTapChiRequest $request): ResponseSuccess
    {
        $validated = $request->validated();
        $tapChi = new TapChi();
        DB::transaction(function () use ($validated, &$tapChi) {
            $tapChi = TapChi::create([
                'name' => $validated['name'],
                'issn' => $validated['issn'],
                'eissn' => $validated['eissn'],
                'pissn' => $validated['pissn'],
                'website' => $validated['website'],
                'quocte' => $validated['quocte'],
                'id_nhaxuatban' => $validated['id_nhaxuatban'],
                'id_donvichuquan' => $validated['id_donvichuquan'],
                'address' => $validated['address'],
                'id_address_city' => $validated['id_address_city'],
                'id_address_country' => $validated['id_address_country'],
                'trangthai' => $validated['trangthai'],
                'id_nguoithem' => auth('api')->user()->id,
            ]);
            //            if($validated['dmnganhtheohdgs'] != null){
            //                $tapChi->dmNganhTheoHDGS()->attach($validated['dmnganhtheohdgs']);
            //            }
        });
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTrangThaiTapChi(UpdateTrangThaiTapChiRequest $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;
        if (!is_int($id_tapchi)) {
            throw new InvalidValueException();
        }

        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $validated = $request->validated();

        $tapChi->trangthai = $validated['trangthai'];
        $tapChi->save();
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTapChi(UpdateTapChiRequest $request, int $id): ResponseSuccess
    {
        $id_tapchi = (int) $id;

        if (!is_int($id_tapchi)) {
            throw new InvalidValueException();
        }

        $tapChi = TapChi::withTrashed()->find($id_tapchi);

        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $validated = $request->validated();

        DB::transaction(function () use ($validated, &$tapChi) {
            $tapChi->name = $validated['name'];
            $tapChi->issn = $validated['issn'];
            $tapChi->eissn = $validated['eissn'];
            $tapChi->pissn = $validated['pissn'];
            $tapChi->website = $validated['website'];
            $tapChi->quocte = $validated['quocte'];
            $tapChi->id_nhaxuatban = $validated['id_nhaxuatban'];
            $tapChi->id_donvichuquan = $validated['id_donvichuquan'];
            $tapChi->address = $validated['address'];
            $tapChi->id_address_city = $validated['id_address_city'];
            $tapChi->id_address_country = $validated['id_address_country'];
            $tapChi->save();
            $tapChi->dmPhanLoaiTapChis()->sync($validated['dmphanloaitapchi']);
            $tapChi->dmNganhTheoHDGS()->sync($validated['dmnganhtheohdgs']);
        });
        $result = Convert::getTapChiVm($tapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateKhongCongNhanTapChi(UpdateTapChiKhongCongNhanRequest $request, int $id): ResponseSuccess
    {

        $tapChi = TapChi::find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $validated = $request->validated();

        $last_recognize = TapChiKhongCongNhan::where('id_tapchi', $id)->orderBy('created_at', 'desc')->first();

        if ($last_recognize && $last_recognize->khongduoccongnhan == $validated['khongduoccongnhan']) {
            throw new UpdateKhongCongNhanException();
        }

        $tapChiKhongCongNhan = TapChiKhongCongNhan::create([
            'id_tapchi' => $tapChi->id,
            'khongduoccongnhan' => $validated['khongduoccongnhan'],
            'ghichu' => $validated['ghichu'],
            'id_nguoicapnhat' => auth('api')->user()->id,
        ]);
        $result = Convert::getTapChiKhongCongNhanVm($tapChiKhongCongNhan);
        return new ResponseSuccess("Thành công", $result);
    }

    public function updateXepHangTapChi(UpdateXepHangTapChiRequest $request, int $id): ResponseSuccess
    {
        $tapChi = TapChi::find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $validated = $request->validated();

        $xepHangTapChi = new XepHangTapChi();
        DB::transaction(function () use ($validated, &$xepHangTapChi, $tapChi) {
            $xepHangTapChi = XepHangTapChi::create([
                'id_tapchi' => $tapChi->id,
                'wos' => $validated['wos'],
                'if' => $validated['if'],
                'quartile' => $validated['quartile'],
                'abs' => $validated['abs'],
                'abcd' => $validated['abcd'],
                'aci' => $validated['aci'],
                'ghichu' => $validated['ghichu'],
                'id_user' => auth('api')->user()->id,
            ]);
            if ($validated['dmphanloaitapchi'] != null) {
                $tapChi->dmPhanLoaiTapChis()->sync($validated['dmphanloaitapchi']);
            }
        });

        $result = Convert::getXepHangTapChiVm($xepHangTapChi);
        return new ResponseSuccess("Thành công", $result);
    }


    public function updateTinhDiemTapChi(UpdateTinhDiemTapChiRequest $request, int $id): ResponseSuccess
    {
        $tapChi = TapChi::find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }

        $validated = $request->validated();

        $cnTinhDiem = DMChuyenNganhTinhDiem::find($validated['id_chuyennganhtinhdiem']);

        if ($cnTinhDiem->nganhTinhDiem->id != $validated['id_nganhtinhdiem']) {
            throw new TinhDiemTapChiException();
        }


        $tinhDiemTapChi = TinhDiemTapChi::create([
            'id_tapchi' => $tapChi->id,
            'id_chuyennganhtinhdiem' => $validated['id_chuyennganhtinhdiem'],
            'id_nganhtinhdiem' => $validated['id_nganhtinhdiem'],
            'diem' => $validated['diem'],
            'namtinhdiem' => $validated['namtinhdiem'],
            'id_nguoicapnhat' => auth('api')->user()->id,
            'ghichu' => $validated['ghichu']
        ]);
        $result = Convert::getTinhDIemTapChiVm($tinhDiemTapChi);
        return new ResponseSuccess("Thành công", $result);
    }



    public function deleteTapChi(int $id): ResponseSuccess
    {

        $tapChi = TapChi::find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        if (!$tapChi->delete()) {
            throw new DeleteFailException();
        }
        return new ResponseSuccess("Thành công", true);
    }

    public function restoreTapChi(int $id): ResponseSuccess
    {

        $tapChi = TapChi::onlyTrashed()->find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        TapChi::onlyTrashed()->where('id', $id)->restore();
        return new ResponseSuccess("Thành công", true);
    }

    public function forceDeleteTapChi(int $id): ResponseSuccess
    {
        $tapChi = TapChi::onlyTrashed()->find($id);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        TapChi::onlyTrashed()->where('id', $id)->forceDelete();
        return new ResponseSuccess("Thành công", true);
    }


    public function themTapChiNgoai($array): TapChi
    {
        $tapChi = TapChi::create([
            'name' => $array['name'],
            'issn' => $array['issn'],
            'eissn' => $array['eissn'],
            'pissn' => $array['pissn'],
            'website' => $array['website']
        ]);
        return $tapChi;
    }
}
