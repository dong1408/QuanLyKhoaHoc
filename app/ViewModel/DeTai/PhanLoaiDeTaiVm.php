<?php

class PhanLoaiDeTaiVm{
    private $id;
    private $maloai;
    private $tenloai;
    private $kinhphi;
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

    function getMaLoai(){
        return $this->maloai;
    }

    function setMaLoai($maloai){
        $this->maloai = $maloai;
    }

    function getTenLoai(){
        return $this->tenloai;
    }

    function setTenLoai($tenloai){
        $this->tenloai = $tenloai;
    }

    function getKinhPhi(){
        return $this->kinhphi;
    }

    function setKinhPhi($kinhphi){
        $this->kinhphi = $kinhphi;
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