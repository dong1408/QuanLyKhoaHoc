<?php

use App\Models\DeTai\BaoCaoTienDo;
use App\ViewModel\SanPham\SanPhamVm;
use Ramsey\Uuid\Type\Integer;

class BaoCaoTienDoVm
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

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    public function getsanpham()
    {
        return $this->sanpham;
    }

    public function setsanpham(SanPhamVm $sanPhamVm)
    {
        $this->sanpham = $sanPhamVm;
    }

    public function getNgayNopBaoCao()
    {
        return $this->ngaynopbaocao;
    }

    public function setNgayNopBaoCao($ngaynopbaocao)
    {
        $this->ngaynopbaocao = $ngaynopbaocao;
    }

    public function getKetQuaXet()
    {
        return $this->ketquaxet;
    }

    public function setKetQuaXet($ketquaxet)
    {
        $this->ketquaxet = $ketquaxet;
    }

    public function getThoiGianGiaHan()
    {
        return $this->thoigiangiahan;
    }

    public function setThoiGianGiaHan($thoigiangiahan)
    {
        $this->thoigiangiahan = $thoigiangiahan;
    }

    function getCreatedAt()
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt()
    {
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
