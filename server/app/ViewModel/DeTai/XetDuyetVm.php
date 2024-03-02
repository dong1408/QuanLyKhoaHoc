<?php

use App\ViewModel\SanPham\SanPhamVm;

class XetDuyetVm{
    public $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public string $ngayxetduyet;
    public string $sohopdong;
    public string $ngaykyhopdong;
    public string $thoihanhopdong;
    public string $kinhphi;
    public string $created_at;
    public string $updated_at;

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

    function getSanPham(){
        return $this->sanpham;
    }

    function setSanPham(SanPhamVm $sanPhamVm){
        $this->sanpham = $sanPhamVm;
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