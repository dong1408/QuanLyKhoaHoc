<?php

use App\ViewModel\SanPham\SanPhamVm;

class BaoCaoTienDoVm
{
    private $id;
    private $sanPhamVM; // $id_sanpham
    private $ngaynopbaocao;
    private $ketquaxet;
    private $thoigiangiahan;
    private $created_at;
    private $updated_at;

    function __construct()
    {
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    public function getSanPhamVm()
    {
        return $this->sanPhamVM;
    }

    public function setSanPhamVm(SanPhamVm $sanPhamVm)
    {
        $this->sanPhamVM = $sanPhamVm;
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
