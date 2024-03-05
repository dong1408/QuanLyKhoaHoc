<?php

namespace App\ViewModel\BaiBao;

use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\TapChi\TapChiVm;
use Ramsey\Uuid\Type\Integer;

class BaiBaoKhoaHocDetailVm
{
    public int $id;
    public SanPhamVm $sanpham;  // $id_sanpham
    public string $doi;
    public string $url;
    public string $received;
    public string $accepted;
    public string $published;
    public string $abstract;
    public string $keywords;
    public TapChiVm $tapchi; // $id_tapchi
    public string $volume;
    public string $issue;
    public string $number;
    public string $page;
    public string $created_at;
    public string $updated_at;

}
