<?php

namespace App\ViewModel\QuyDoi;

use Ramsey\Uuid\Type\Integer;

class ChuyenNganhTinhDiemVm
{
    public Integer $id;
    public NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem 
    public string $machuyennganh;
    public string $tenchuyennganh;
    public string $tenchuyennganh_en;
    public string $created_at;
    public string $updated_at;

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

    function getNganhTinhDiem()
    {
        return $this->nganhtinhdiem;
    }

    function setNganhTinhDiem(NganhTinhDiemVm $nganhTinhDiemVm)
    {
        $this->nganhtinhdiem = $nganhTinhDiemVm;
    }

    function getMaChuyenNganh()
    {
        return $this->machuyennganh;
    }

    function setMaChuyenNganh($machuyennganh)
    {
        $this->machuyennganh = $machuyennganh;
    }

    function getTenChuyenNganh()
    {
        return $this->tenchuyennganh;
    }

    function setTenChuyenNganh($tenchuyennganh)
    {
        $this->tenchuyennganh = $tenchuyennganh;
    }

    function getTenChuyenNganh_en()
    {
        return $this->tenchuyennganh_en;
    }

    function setTenChuyenNganh_en($tenchuyennganh_en)
    {
        $this->tenchuyennganh_en = $tenchuyennganh_en;
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
