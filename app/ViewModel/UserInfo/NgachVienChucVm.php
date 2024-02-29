<?php

namespace App\ViewModel\UserInfo;

class NgachVienChucVm
{
    private $id;
    private $mangach;
    private $tenngach;
    private $tenngach_en;
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

    function getMaNgach()
    {
        return $this->mangach;
    }

    function setMaNgach($mangach)
    {
        $this->mangach = $mangach;
    }

    function getTenNgach()
    {
        return $this->tenngach;
    }

    function setTenNgach($tenngach)
    {
        $this->tenngach = $tenngach;
    }

    function getTenNgach_en(){
        return $this->tenngach_en;
    }

    function setTenNgach_en($tenngach_en){
        $this->tenngach_en = $tenngach_en;
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
