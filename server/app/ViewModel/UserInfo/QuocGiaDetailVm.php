<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMQuocGia;
use Ramsey\Uuid\Type\Integer;

class QuocGiaDetailVm
{
    public int $id;
    public string $maquocgia;
    public string $tenquocgia;
    public string $tenquocgia_en;
    public string $created_at;
    public string $updated_at;

    public function __construct()
    {
    }

    public function convert(DMQuocGia $dMQuocGia)
    {
        $this->id = $dMQuocGia->id;
        $this->maquocgia = $dMQuocGia->maquocgia;
        $this->tenquocgia = $dMQuocGia->tenquocgia;
        $this->tenquocgia_en = $dMQuocGia->tenquocgia_en;
        $this->created_at = $dMQuocGia->created_at;
        $this->updated_at = $dMQuocGia->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getMaQuocGia()
    {
        return $this->maquocgia;
    }

    function setMaQuocGia($maquocgia)
    {
        $this->maquocgia = $maquocgia;
    }

    function getTenQuocGia()
    {
        return $this->tenquocgia;
    }

    function setTenQuocGia($tenquocgia)
    {
        $this->tenquocgia = $tenquocgia;
    }

    function getTenQuocGia_en()
    {
        return $this->tenquocgia_en;
    }

    function setTenQuocGia_en($tenquocgia_en)
    {
        $this->tenquocgia_en = $tenquocgia_en;
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
