<?php

namespace App\Service\UserInfo;

use App\Exceptions\InvalidValueException;
use App\Exceptions\UserInfo\ToChucNotFoundException;
use App\Http\Requests\UserInfo\ToChuc\CreateToChucRequest;
use App\Http\Requests\UserInfo\ToChuc\UpdateToChucRequest;
use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMToChuc;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToChucServiceImpl implements ToChucService
{
    public function getAllToChuc(Request $request): ResponseSuccess
    {
        $keysearch = $request->query('search', "");
        $result = [];
        if (!empty($keysearch)) {
            $toChucs = DMToChuc::where('tentochuc', 'LIKE', '%' . $keysearch . '%')->take(10)->get();
            foreach ($toChucs as $toChuc) {
                $result[] = Convert::getToChucVm($toChuc);
            }
        }
        return new ResponseSuccess("Thành công", $result);
    }


    public function getToChucPaging(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");

        $toChucs = DMToChuc::where(function ($query) use ($keysearch) {
            $query->where('matochuc', 'LIKE', '%' . $keysearch . '%')
                ->orwhere('tentochuc', 'LIKE', '%' . $keysearch . '%')
                ->orwhere('tentochuc_en', 'LIKE', '%' . $keysearch . '%');
        })->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);

        $result = [];
        foreach ($toChucs as $toChuc) {
            $result[] = Convert::getToChucVm($toChuc);
        }
        $pagingResponse = new PagingResponse($toChucs->lastPage(), $toChucs->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getDetailToChuc(int $id): ResponseSuccess
    {
        $toChucId = (int)$id;
        if (!is_int($toChucId)) {
            throw new InvalidValueException();
        }

        $toChuc = DMToChuc::where('id', $toChucId)->first();
        if ($toChuc == null) {
            throw new ToChucNotFoundException();
        }

        $result = Convert::getToChucDetailVm($toChuc);
        return new ResponseSuccess("Thành công", $result);
    }



    public function themToChucNgoai($array): DMToChuc
    {
        $toChuc = DMToChuc::create([
            'tentochuc' => $array['tentochuc']
        ]);
        return $toChuc;
    }



    public function createToChuc(CreateToChucRequest $request): ResponseSuccess
    {
        $validated = $request->validated();

        $toChuc = DMToChuc::create([
            'matochuc' => $validated['matochuc'],
            'tentochuc' => $validated['tentochuc'],
            'tentochuc_en' => $validated['tentochuc_en'],
            'website' => $validated['website'],
            'dienthoai' => $validated['dienthoai'],
            'address' => $validated['address'],
            'id_address_city' => $validated['id_address_city'],
            'id_address_country' => $validated['id_address_country'],
            'id_phanloaitochuc' => $validated['id_phanloaitochuc'],
        ]);
        $result = Convert::getToChucVm($toChuc);
        return new ResponseSuccess("Tạo tổ chức thành công", $result);
    }



    public function updateToChuc(UpdateToChucRequest $request, int $id): ResponseSuccess
    {
        $toChucId = (int)$id;
        if (!is_int($toChucId)) {
            throw new InvalidValueException();
        }

        $toChuc = DMToChuc::where('id', $toChucId)->first();
        if ($toChuc == null) {
            throw new ToChucNotFoundException();
        }
        $validated = $request->validated();

        $toChuc->matochuc = $validated['matochuc'];
        $toChuc->tentochuc = $validated['tentochuc'];
        $toChuc->tentochuc_en = $validated['tentochuc_en'];
        $toChuc->website = $validated['website'];
        $toChuc->dienthoai = $validated['dienthoai'];
        $toChuc->address = $validated['address'];
        $toChuc->id_address_city = $validated['id_address_city'];
        $toChuc->id_address_country = $validated['id_address_country'];
        $toChuc->id_phanloaitochuc = $validated['id_phanloaitochuc'];

        $toChuc->save();
        $result = Convert::getToChucVm($toChuc);
        return new ResponseSuccess("Cập nhật tổ chức thành công", $result);
    }

    public function deleteToChuc(int $id): ResponseSuccess
    {
        $toChucId = (int)$id;
        if (!is_int($toChucId)) {
            throw new InvalidValueException();
        }

        $toChuc = DMToChuc::where('id', $toChucId)->first();
        if ($toChuc == null) {
            throw new ToChucNotFoundException();
        }
        $toChuc->delete();
        return new ResponseSuccess("Xóa tổ chức thành công", true);
    }
}
