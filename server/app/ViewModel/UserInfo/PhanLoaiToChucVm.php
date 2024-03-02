<?php

namespace App\ViewModel\UserInfo;

use Ramsey\Uuid\Type\Integer;

class PhanLoaiToChucVm
{
    public Integer $id;
    public string $maloai;
    public string $tenloai;
    public string $tenloai_en;
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

    function getMaLoai()
    {
        return $this->maloai;
    }

    function setMaLoai($maloai)
    {
        $this->maloai = $maloai;
    }

    function getTenLoai()
    {
        return $this->tenloai;
    }

    function setTenLoai($tenloai)
    {
        $this->tenloai = $tenloai;
    }

    function getTenLoai_en()
    {
        return $this->tenloai_en;
    }

    function setTenLoai_en($tenloai_en)
    {
        $this->tenloai_en = $tenloai_en;
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
