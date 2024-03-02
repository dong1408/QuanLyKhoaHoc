<?php

namespace App\ViewModel\TapChi;

use Ramsey\Uuid\Type\Integer;

class NganhTheoHDGSVm
{
    public Integer $id;
    public string $ma;
    public string $ten;
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
