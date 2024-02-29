<?php

use App\ViewModel\SanPham\SanPhamVm;

class XetDuyetVm{
    private $id;
    private $sanPhamVm; // $id_sanpham
    private $ngayxetduyet;
    private $sohopdong;
    private $ngaykyhopdong;
    private $thoihanhopdong;
    private $kinhphi;
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

    function getSanPhamVm(){
        return $this->sanPhamVm;
    }

    function setSanPhamVm(SanPhamVm $sanPhamVm){
        $this->sanPhamVm = $sanPhamVm;
    }

    function getNgayXetDuyet(){
        return $this->ngayxetduyet;
    }

    function setNgayXetDuyet($ngayxetduyet){
        $this->ngayxetduyet = $ngayxetduyet;
    }

    function getSoHopDong(){
        return $this->sohopdong;
    }

    function setSoHopDong($sohopdong){
        $this->sohopdong = $sohopdong;
    }

    function getNgayKyHopDong(){
        return $this->ngaykyhopdong;
    }

    function setNgayKyHopDong($ngaykyhopdong){
        $this->ngaykyhopdong = $ngaykyhopdong;
    }

    function getThoiHanHopDong(){
        return $this->thoihanhopdong;
    }

    function setThoiHanHopDong($thoihanhopdong){
        $this->thoihanhopdong = $thoihanhopdong;
    }

    function getKinhPhi(){
        return $this->kinhphi;
    }

    function setKinhPhi($kinhphi){
        $this->kinhphi = $kinhphi;
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