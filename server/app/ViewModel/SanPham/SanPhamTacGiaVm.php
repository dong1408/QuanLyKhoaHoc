<?php

namespace App\ViewModel\SanPham;

use App\ViewModel\User\UserSimpleVm;
use App\ViewModel\UserInfo\HocHamHocViVm;
use App\ViewModel\UserInfo\ToChucVm;

class SanPhamTacGiaVm
{
    public int $id;
    //public ?SanPhamVm $sanpham; //$id_sanpham
    public UserSimpleVm $tacgia; // $id_tacgia -- user
    public VaiTroTacGiaVm $vaitrotacgia; //$id_vaotrotacgia
    public ?ToChucVm $tochuc;
    public ?HocHamHocViVm $hochamhocvi;
    public string $email;
    public ?string $dienthoai;
    public ?string $ngaysinh;
    public ?int $thutu;
    public ?int $tyledonggop;
    public string $created_at;
    public string $updated_at;
}
