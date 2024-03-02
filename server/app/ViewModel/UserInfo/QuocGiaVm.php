<?php

namespace App\ViewModel\UserInfo;

use Ramsey\Uuid\Type\Integer;

class QuocGiaVm
{
    public Integer $id;
    public string $maquocgia;
    public string $tenquocgia;
    public string $tenquocgia_en;
    public string $created_at;
    public string$updated_at;

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
