<?php

namespace App\Http\Controllers\Admin\BaiBao;

use App\Http\Controllers\Controller;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\ViewModel\BaiBao\BaiBaoKhoaHocVm;
use Illuminate\Http\Request;

class BaiBaoKhoaHocController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAll()
    {
        // $baiBaoVm = new \App\ViewModel\BaiBao\BaiBaoKhoaHocVm();
        $baiBaoVm = new BaiBaoKhoaHocVm();
        $data = BaiBaoKhoaHoc::all();
        return response()->json("abc");
    }

    
}
