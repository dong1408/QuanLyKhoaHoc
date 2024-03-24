<?php

namespace App\ViewModel\SanPham;

use App\ViewModel\User\UserSimpleVm;

class SanPhamTacGiaVm
{
    public int $id;
    //public ?SanPhamVm $sanpham; //$id_sanpham
    public UserSimpleVm $tacgia; // $id_tacgia -- user
    public VaiTroTacGiaVm $vaitrotacgia; //$id_vaotrotacgia
    public ?int $thutu;
    public ?int $tyledonggop;
    public string $created_at;
    public string $updated_at;
}
