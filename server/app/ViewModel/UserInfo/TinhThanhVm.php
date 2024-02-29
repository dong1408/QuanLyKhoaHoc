<?php

namespace App\ViewModel\UserInfo;

class TinhThanhVm
{
    private $id;
    private $quocGiaVm; // $id_quocgia
    private $matinhthanh;
    private $tentinhthanh;
    private $tentinhthanh_en;
    private $created_at;
    private $updated_at;

    public function __construct()
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

    function getQuocGiaVm()
    {
        return $this->quocGiaVm;
    }

    function setQuocGiaVm(QuocGiaVm $quocGiaVm)
    {
        $this->quocGiaVm = $quocGiaVm;
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
