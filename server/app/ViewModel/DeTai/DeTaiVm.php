<?php

use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\UserInfo\ToChucVm;

class DeTaiVm
{
    private $id;
    private $sanPhamVM; // $id_sanpham
    private $maso;
    private $ngaydangky;
    private $ngoaitruong;
    private $truongchutri;
    private $tochucchuquanVm; // $id_tochuchuquan -- tochuc
    private $loaidetaiVm; // $id_loaidetai -- phanloaidetai
    private $detaihoptac;
    private $tochuchoptacVm; // $id_tochuchoptac -- tochuc
    private $tylekinhphidonvihoptac;
    private $capdetai;
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

    function getSanPhamVm()
    {
        return $this->sanPhamVM;
    }

    function setSanPhamVm(SanPhamVm $sanPhamVM)
    {
        $this->sanPhamVM = $sanPhamVM;
    }

    function getMaSo()
    {
        return $this->maso;
    }

    function setMaSo($maso)
    {
        $this->maso = $maso;
    }

    function getNgayDangKy()
    {
        return $this->ngaydangky;
    }

    function setNgayDangKy($ngaydangky)
    {
        $this->ngaydangky = $ngaydangky;
    }

    function getNgoaiTruong()
    {
        return $this->ngoaitruong;
    }

    function setNgoaiTruong($ngoaitruong)
    {
        $this->ngoaitruong = $ngoaitruong;
    }

    function getTruongChuTri()
    {
        return $this->truongchutri;
    }

    function setTruongChuTri($truongchutri)
    {
        $this->truongchutri = $truongchutri;
    }

    function getToChucChuQuanVm()
    {
        return $this->tochucchuquanVm;
    }

    function setToChucChuQuanVm(ToChucVm $tochucchuquanVm)
    {
        $this->tochucchuquanVm = $tochucchuquanVm;
    }

    function getLoaiDeTaiVm()
    {
        return $this->loaidetaiVm;
    }

    function setLoaiDeTaiVm(PhanLoaiDeTaiVm $loaidetaiVm)
    {
        $this->loaidetaiVm = $loaidetaiVm;
    }

    function getDeTaiHopTac()
    {
        return $this->detaihoptac;
    }

    function setDeTaiHopTac($detaihoptac)
    {
        $this->detaihoptac = $detaihoptac;
    }

    function getToChucHopTacVm()
    {
        return $this->tochuchoptacVm;
    }

    function setToChucHopTacVm(ToChucVm $tochuchoptacVm)
    {
        $this->tochuchoptacVm = $tochuchoptacVm;
    }

    function getTyLeKinhPhiDonViHopTac()
    {
        return $this->tylekinhphidonvihoptac;
    }

    function setTyLeKinhPhiDonViHopTac($tylekinhphidonvihoptac)
    {
        $this->tylekinhphidonvihoptac = $tylekinhphidonvihoptac;
    }

    function getCapDeTai()
    {
        return $this->capdetai;
    }

    function setCapDeTai($capdetai)
    {
        $this->capdetai = $capdetai;
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
