<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMTinhThanh;
use Ramsey\Uuid\Type\Integer;

class TinhThanhVm
{
    public int $id;
    public string $matinhthanh;
    public string $tentinhthanh;
    public string $tentinhthanh_en;
    public string $created_at;
    public string $updated_at;

    private $quocGiaVm;

    public function __construct()
    {
        $this->quocGiaVm = new QuocGiaVm();
    }

    public function convert(DMTinhThanh $dMTinhThanh)
    {
        $this->id = $dMTinhThanh->id;
        $this->quocgia = $this->quocGiaVm->convert($dMTinhThanh->quocGia);
        $this->matinhthanh = $dMTinhThanh->matinhthanh;
        $this->tentinhthanh = $dMTinhThanh->tentinhthanh;
        $this->tentinhthanh_en = $dMTinhThanh->tentinhthanh_en;
        $this->created_at = $dMTinhThanh->created_at;
        $this->updated_at = $dMTinhThanh->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getQuocGia()
    {
        return $this->quocgia;
    }

    function setQuocGia(QuocGiaVm $quocGiaVm)
    {
        $this->quocgia = $quocGiaVm;
    }

    function getMaTinhThanh()
    {
        return $this->matinhthanh;
    }

    function setMaTinhThanh($matinhthanh)
    {
        $this->matinhthanh = $matinhthanh;
    }

    function getTenTinhThanh()
    {
        return $this->tentinhthanh;
    }

    function setTenTinhThanh($tentinhthanh)
    {
        $this->tentinhthanh = $tentinhthanh;
    }

    function getTenTinhThanh_en()
    {
        return $this->tentinhthanh_en;
    }

    function setTenTinhThanh_en($tentinhthanh_en)
    {
        $this->tentinhthanh_en = $tentinhthanh_en;
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
