<?php

use App\Models\DeTai\XetDuyet;
use App\ViewModel\SanPham\SanPhamVm;

class XetDuyetVm
{
    public int $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public ?string $ngayxetduyet;
    public ?string $ketquaxetduyet;
    public ?string $sohopdong;
    public ?string $ngaykyhopdong;
    public ?string $thoihanhopdong;
    public ?string $kinhphi;
    public string $created_at;
    public string $updated_at;

}
