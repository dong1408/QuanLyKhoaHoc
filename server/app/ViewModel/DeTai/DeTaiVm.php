<?php

use App\Models\DeTai\DeTai;
use App\Models\SanPham\SanPham;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class DeTaiVm
{
    public int $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public string $maso;
    public string $ngaydangky;
    public Boolean $ngoaitruong;
    public Boolean $truongchutri;
    public ToChucVm $tochucchuquan; // $id_tochuchuquan -- tochuc
    public PhanLoaiDeTaiVm $loaidetai; // $id_loaidetai -- phanloaidetai
    public Boolean $detaihoptac;
    public ToChucVm $tochuchoptac; // $id_tochuchoptac -- tochuc
    public string $tylekinhphidonvihoptac;
    public string $capdetai;
    public $created_at;
    public $updated_at;


    private $sanPhamVM;
    private $toChucChuQuanVm;
    private $loaiDeTaiVm;
    private $toChucHopTacVm;    

    function __construct()
    {
        $this->sanPhamVM = new SanPhamVm();
        $this->toChucChuQuanVm = new ToChucVm();
        $this->loaiDeTaiVm = new PhanLoaiDeTaiVm();
        $this->toChucHopTacVm = new ToChucVm(); 
    }

    public function convert(DeTai $deTai)
    {
        $this->id = $deTai->id;
        $this->sanpham = $this->sanPhamVM->convert($deTai->sanPham);
        $this->maso = $deTai->maso;
        $this->ngaydangky = $deTai->ngaydangky;
        $this->ngoaitruong = $deTai->ngoaitruong;
        $this->truongchutri = $deTai->truongchutri;
        $this->tochucchuquan = $this->toChucChuQuanVm->convert($deTai->toChucChuQuan);
        $this->loaidetai = $this->loaiDeTaiVm->convert($deTai->phanLoaiDeTai);
        $this->detaihoptac = $deTai->detaihoptac;
        $this->tochuchoptac = $this->toChucHopTacVm->convert($deTai->toChucHopTac);
        $this->tylekinhphidonvihoptac = $deTai->tylekinhphidonvihoptac;
        $this->capdetai = $deTai->capdetai;
        $this->created_at = $deTai->created_at;
        $this->updated_at = $deTai->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getSanPham()
    {
        return $this->sanpham;
    }

    function setSanPham(SanPhamVm $sanPhamVM)
    {
        $this->sanpham = $sanPhamVM;
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

    function getToChucChuQuan()
    {
        return $this->tochucchuquan;
    }

    function setToChucChuQuan(ToChucVm $tochucchuquanVm)
    {
        $this->tochucchuquan = $tochucchuquanVm;
    }

    function getLoaiDeTai()
    {
        return $this->loaidetai;
    }

    function setLoaiDeTai(PhanLoaiDeTaiVm $loaidetaiVm)
    {
        $this->loaidetai = $loaidetaiVm;
    }

    function getDeTaiHopTac()
    {
        return $this->detaihoptac;
    }

    function setDeTaiHopTac($detaihoptac)
    {
        $this->detaihoptac = $detaihoptac;
    }

    function getToChucHopTac()
    {
        return $this->tochuchoptac;
    }

    function setToChucHopTac(ToChucVm $tochuchoptacVm)
    {
        $this->tochuchoptac = $tochuchoptacVm;
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
