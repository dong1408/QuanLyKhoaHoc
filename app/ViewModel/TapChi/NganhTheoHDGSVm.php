<?php

namespace App\ViewModel\TapChi;

class NganhTheoHDGSVm
{
    private $id;
    private $ma;
    private $ten;
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

    function getMa()
    {
        return $this->ma;
    }

    function setMa($ma)
    {
        $this->ma = $ma;
    }

    function getTen()
    {
        return $this->ten;
    }

    function setTen($ten)
    {
        $this->ten = $ten;
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
