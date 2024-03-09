<?php

namespace App\ViewModel\BaiBao;

use App\ViewModel\SanPham\SanPhamDetailVm;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\TapChi\TapChiVm;

class BaiBaoKhoaHocDetailVm
{
    public int $id;
    public SanPhamDetailVm $sanpham;  // $id_sanpham
    public ?string $doi;
    public ?string $url;
    public ?string $received;
    public ?string $accepted;
    public ?string $published;
    public ?string $abstract;
    public ?string $keywords;
    public ?TapChiVm $tapchi; // $id_tapchi
    public ?string $volume;
    public ?string $issue;
    public ?string $number;
    public ?string $pages;
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;

    public $sanpham_tacgias = array();

}
