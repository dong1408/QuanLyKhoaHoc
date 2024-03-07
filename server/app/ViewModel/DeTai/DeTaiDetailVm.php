<?php

use App\Models\DeTai\DeTai;
use App\Models\SanPham\SanPham;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class DeTaiDetailVm
{
    public int $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public string $maso;
    public ?string $ngaydangky;
    public ?bool $ngoaitruong;
    public ?bool $truongchutri;
    public ?ToChucVm $tochucchuquan; // $id_tochuchuquan -- tochuc
    public ?PhanLoaiDeTaiVm $loaidetai; // $id_loaidetai -- phanloaidetai
    public ?bool $detaihoptac;
    public ?ToChucVm $tochuchoptac; // $id_tochuchoptac -- tochuc
    public ?string $tylekinhphidonvihoptac;
    public ?string $capdetai;
    public $created_at;
    public $updated_at;
}
