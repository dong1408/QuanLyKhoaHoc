<?php

namespace App\ViewModel\BaiBao;

use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\TapChi\TapChiVm;

class BaiBaoKhoaHocVm
{
    public int $id;
    //public SanPhamVm $sanpham;  // $id_sanpham
    public string $tensanpham;
    public string $id_sanpham;
    public ?string $doi;
    public ?string $url;
    public ?string $received;
    public ?string $accepted;
    public ?string $published;
    public ?string $keywords;
    //public ?TapChiVm $tapchi; // $id_tapchi
    public ?string $trangthairasoat;
    public ?string $tentapchi;
    public ?string $volume;
    public ?string $issue;
    public ?string $number;
    public ?string $pages;
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;
}
