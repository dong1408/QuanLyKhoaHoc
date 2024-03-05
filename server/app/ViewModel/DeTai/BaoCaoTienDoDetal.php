<?php

use App\Models\DeTai\BaoCaoTienDo;
use App\ViewModel\SanPham\SanPhamVm;
use Ramsey\Uuid\Type\Integer;

class BaoCaoTienDoDetailVm
{
    public int $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public string $ngaynopbaocao;
    public string $ketquaxet;
    public string $thoigiangiahan;
    public string $created_at;
    public string $updated_at;


    private $sanPhamVm;

    public function __construct()
    {
        $this->sanPhamVm = new SanPhamVm();
    }

    public function convert(BaoCaoTienDo $baoCaoTienDo)
    {
        $this->id = $baoCaoTienDo->id;
        $this->sanpham = $this->sanPhamVm->convert($baoCaoTienDo->sanPham);
        $this->ngaynopbaocao = $baoCaoTienDo->getNgayNopBaoCao;
        $this->ketquaxet = $baoCaoTienDo->ketquaxet;
        $this->thoigiangiahan = $baoCaoTienDo->thoigiangiahan;
        $this->created_at = $baoCaoTienDo->created_at;
        $this->updated_at = $baoCaoTienDo->updated_at;
    }

}
