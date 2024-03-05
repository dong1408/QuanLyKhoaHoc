<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\DMVaiTroTacGia;
use Ramsey\Uuid\Type\Integer;

class VaiTroTacGiaVm
{
    public int $id;
    public string $tenvaitro;
    public string $tenvaitro_en;
    public string $mota;
    public string $created_at;
    public string $updated_at;

    function __construct()
    {
    }

    public function convert(DMVaiTroTacGia $dmVaiTroTacGia)
    {
        $this->id = $dmVaiTroTacGia->id;
        $this->tenvaitro = $dmVaiTroTacGia->tenvaitro;
        $this->tenvaitro_en = $dmVaiTroTacGia->tenvaitro_en;
        $this->mota = $dmVaiTroTacGia->mota;
        $this->created_at = $dmVaiTroTacGia->created_at;
        $this->updated_at = $dmVaiTroTacGia->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getTenVaiTro()
    {
        return $this->tenvaitro;
    }

    function setTenVaiTro($tenvaitro)
    {
        $this->tenvaitro = $tenvaitro;
    }

    function getTenVaiTro_en()
    {
        return $this->tenvaitro_en;
    }

    function setTenVaiTro_en($tenvaitro_en)
    {
        $this->tenvaitro_en = $tenvaitro_en;
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
