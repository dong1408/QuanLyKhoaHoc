<?php

namespace App\ViewModel\QuyDoi;

class NganhTinhDiemVm
{
    private $id;
    private $manganhtinhdiem;
    private $tennganhtinhdiem;
    private $tennganh_en;
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

    function getMaNganhTinhDiem()
    {
        return $this->manganhtinhdiem;
    }

    function setMaNganhTinhDiem($manganhtinhdiem)
    {
        $this->manganhtinhdiem = $manganhtinhdiem;
    }

    function getTenNganhTinhDiem()
    {
        return $this->tennganhtinhdiem;
    }

    function setTenNganhTinhDiem($tennganhtinhdiem)
    {
        $this->tennganhtinhdiem = $tennganhtinhdiem;
    }

    function getTenNganhTinhDiem_en()
    {
        return $this->tennganh_en;
    }

    function setTenNganhTinhDiem_en($tennganh_en)
    {
        $this->tennganh_en = $tennganh_en;
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
