<?php

namespace App\Http\Controllers\Admin\BaiBao;

use App\Http\Controllers\Controller;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\User;
use App\Models\UserInfo\DMTinhThanh;
use App\Models\UserInfo\DMQuocGia;
use App\Utilities\ResponseError;
use App\ViewModel\BaiBao\BaiBaoKhoaHocVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BaiBaoKhoaHocController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'getAll']);
    }

    public function getAll()
    {
        // $baiBaoVm = new \App\ViewModel\BaiBao\BaiBaoKhoaHocVm();
        // $baiBaoVm = new BaiBaoKhoaHocVm();
        // $data = BaiBaoKhoaHoc::all();

        // $data = User::all();
        // $userVm = new UserVm();
        // $userVm->setId("a");
        // $userVm->setUsername("TranVanDong");
        // $userVm->setName("Bronze140802");
        // $userVm->setEmail("dongden14082002@gmail.com");
        // return response()->json($data[1]);//run coi


        // $tinhthanh = DMTinhThanh::find(1);
        // $quocgia = $tinhthanh->quocGia;
        // return response()->json($tinhthanh);

        // $tinhThanhVm = new TinhThanhVm();
        // $quocGiaVm = new QuocGiaVm();

        // $quocGiaVm->setId(1);
        // $quocGiaVm->setTenQuocGia("VietNam");

        // $tinhThanhVm->setId(1);
        // $tinhThanhVm->setTenTinhThanh("NamDInh");
        // $tinhThanhVm->setQuocGiaVm($quocGiaVm);

        // return response()->json($tinhThanhVm);

        // chi cho cai nay, mot may cai Vm ay', m tach no ra thanh 1 ham` rieng

        // $quocgia = DMQuocGia::find(1);
        // $tinhthanhs = $quocgia->tinhThanhs;
        // return response()->json($tinhthanhs);

        $user = new User();
        $user->name = "Bronze14082002";
        $user->username = "Tran Van Dong";
        $user->email = "dongden14082002@gmail.com";
        $user->password = Hash::make("vandong123");
        $user->save();

        // $user = User::create([
        //     'name' => "Bronze14082002",
        //     "username" => "Tran Van Dong",
        //     'email' => "dongden14082002@gmail.com",
        //     'password' => Hash::make("vandong123")
        // ]);

    }
}
