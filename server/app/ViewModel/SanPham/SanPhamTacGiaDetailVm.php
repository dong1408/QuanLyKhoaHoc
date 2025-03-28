<?php

namespace App\ViewModel\SanPham;

use App\ViewModel\User\UserVm;

class SanPhamTacGiaDetailVm
{
    public int $id;
    public SanPhamVm $sanpham; //$id_sanpham
    public UserVm $tacgia; // $id_tacgia -- user
    public VaiTroTacGiaVm $vaitrotacgia; //$id_vaotrotacgia 
    public ?int $thutu;
    public ?int $tyledonggop;
    public string $created_at;
    public string $updated_at;

}
