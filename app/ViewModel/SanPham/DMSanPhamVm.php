<?php

namespace App\ViewModel\SanPham;

class DMSanPhamVm{
    private $id;
    private $madmsanpham;
    private $tendmsanpham;
    private $mota;
    private $created_at;
    private $updated_at;

    function __construct()
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

    function getMaDmSanPham(){
        return $this->madmsanpham;
    }

    function setMaDmSanPham($madmsanpham){
        $this->madmsanpham = $madmsanpham;
    }

    function getTenDmSanPham(){
        return $this->tendmsanpham;
    }

    function setTenDmSanPham($tendmsanpham){
        $this->tendmsanpham = $tendmsanpham;
    }

    function getMoTa(){
        return $this->mota;
    }

    function setMoTa($mota){
        $this->mota = $mota;
    }

    function getCreatedAt(){
        return $this->created_at;
    }

    function setCreatedAt($created_at){
        $this->created_at = $created_at;
    }

    function getUpdatedAt(){
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at){
        $this->updated_at = $updated_at;
    }
}

?>