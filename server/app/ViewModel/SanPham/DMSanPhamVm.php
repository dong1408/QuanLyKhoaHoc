<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\DMSanPham;
use Ramsey\Uuid\Type\Integer;

class DMSanPhamVm
{
    public int $id;
    public string $madmsanpham;
    public string $tendmsanpham;
    public string $mota;
    public string $created_at;
    public string $updated_at;

    function __construct()
    {
    }

    public function convert(DMSanPham $dmSanPham)
    {
        $this->id = $dmSanPham->id;
        $this->madmsanpham = $dmSanPham->madmsanpham;
        $this->tendmsanpham = $dmSanPham->tensanpham;
        $this->mota = $dmSanPham->mota;
        $this->created_at = $dmSanPham->created_at;
        $this->updated_at = $dmSanPham->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getMaDmSanPham()
    {
        return $this->madmsanpham;
    }

    function setMaDmSanPham($madmsanpham)
    {
        $this->madmsanpham = $madmsanpham;
    }

    function getTenDmSanPham()
    {
        return $this->tendmsanpham;
    }

    function setTenDmSanPham($tendmsanpham)
    {
        $this->tendmsanpham = $tendmsanpham;
    }

    function getMoTa()
    {
        return $this->mota;
    }

    function setMoTa($mota)
    {
        $this->mota = $mota;
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
