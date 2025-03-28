<?php

namespace App\ViewModel\DeTai;

use App\Models\DeTai\DeTai;
use App\ViewModel\SanPham\SanPhamDetailVm;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class DeTaiDetailVm
{
    public int $id;
    public SanPhamDetailVm $sanpham; // $id_sanpham    
    public string $maso;
    public string $trangthai;
    public ?string $ngaydangky;
    public ?bool $ngoaitruong;
    public ?bool $truongchutri;
    public ?ToChucVm $tochucchuquan; // $id_tochuchuquan -- tochuc
    public ?PhanLoaiDeTaiVm $loaidetai; // $id_loaidetai -- phanloaidetai
    public ?bool $detaihoptac;
    public ?ToChucVm $tochuchoptac; // $id_tochuchoptac -- tochuc
    public ?string $tylekinhphidonvihoptac;
    public ?string $capdetai;
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;
    public ?string $trangthairasoat;
    public string $tensanpham;

    public ?TuyenChonVm $tuyenchon;
    public ?XetDuyetVm $xetduyet;
    public ?NghiemThuVm $nghiemthu;

    public $sanpham_tacgias = array();

    public ?array $lichsubaocao;
}
