<?php

use App\Models\DeTai\NghiemThu;
use App\ViewModel\SanPham\SanPhamVm;

class NghiemThuVm
{
    public $id;
    public SanPhamVm $sanpham; // $id_sanpham;
    public ?string $hoidongnghiemthu;
    public ?string $ngaynghiemthu;
    public ?string $ketquanghiemthu;
    public ?string $ngaycongnhanhoanthanh;
    public ?string $soqdcongnhanhoanthanh;
    public ?string $thoigianhoanthanh;
    public string $created_at;
    public string $updated_at;
}
