<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\SanPham;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class SanPhamDetailVm
{
    public int $id;
    public string $tensanpham;
    public ?DMSanPhamVm $loaisanpham; // $id_loaisanpham -- DMSanPhamVm
    public int $tongsotacgia;
    public int $solandaquydoi;
    public ?bool $cosudungemailtruong;
    public ?bool $cosudungemaildonvikhac;
    public ?bool $cothongtintruong;
    public ?bool $cothongtindonvikhac;
    public ?ToChucVm $thongtinnoikhac; // $id_thongtinnoikhac -- ToChucVm
    public ?bool $conhantaitro;
    public ?ToChucVm $donvitaitro; // $id_donvitaitro -- ToChucVm
    public ?string $chitietdonvitaitro;
    public string $ngaykekhai;
    public ?UserVm $nguoikekhai; // $id_nguoikekhai -- UserVm
    public string $trangthairasoat;
    public string $ngayrasoat;
    public ?UserVm $nguoirasoat; // $id_nguoirasoat -- UserVm
    public string $diemquydoi;
    public string $gioquydoi;
    public string $thongtinchitiet;
    public string $capsanpham;
    public string $thoidiemcongbohoanthanh;
    public ?FileMinhChungSanPhamVm $fileMinhChungSanPham; 
    public string $created_at;
    public string $updated_at;
    // thêm file minh chứngVM.

    public $sanpham_tacgia = array();
}
