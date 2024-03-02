<?php

namespace App\ViewModel\BaiBao;

use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\TapChi\TapChiVm;
use Ramsey\Uuid\Type\Integer;

class BaiBaoKhoaHocVm
{
    public Integer $id;
    public SanPhamVm $sanpham;  // $id_sanpham
    public string $doi;
    public string $url;
    public string $received;
    public string $accepted;
    public string $published;
    public string $abstract;
    public string $keywords;
    public TapChiVm $tapchi; // $id_tapchi
    public string $volume;
    public string $issue;
    public string $number;
    public string $page;
    public string $created_at;
    public string $updated_at;


    function __construct()
    {
    }

    // function convert(BaiBaoKhoaHoc $baiBaoKhoaHoc)
    // {
    //     $this->id = $baiBaoKhoaHoc->id;
    //     $this->sanpham = sanphamVm->convert($baiBaoKhoaHoc->sanPham);
    //     $this->doi = $baiBaoKhoaHoc->doi;
    //     $this->url = $baiBaoKhoaHoc->url;
    //     $this->received = $baiBaoKhoaHoc->recieived;
    //     $this->accepted = $baiBaoKhoaHoc->accepted;
    //     $this->published = $baiBaoKhoaHoc->published;
    //     $this->abstract = $baiBaoKhoaHoc->abstract;
    //     $this->keywords = $baiBaoKhoaHoc->keywords;
    //     $this->tapchi = tapchiVm->convert($baiBaoKhoaHoc->tapChi);
    //     $this->volume = $baiBaoKhoaHoc->volume;
    //     $this->issue = $baiBaoKhoaHoc->issue;
    //     $this->number = $baiBaoKhoaHoc->number;
    //     $this->page = $baiBaoKhoaHoc->page;
    //     $this->created_at = $baiBaoKhoaHoc->created_at;
    //     $this->updated_at = $baiBaoKhoaHoc->updated_at;
    // }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getSanPham()
    {
        return $this->sanpham;
    }

    function setSanPham(SanPhamVm $sanPhamVm)
    {
        $this->sanpham = $sanPhamVm;
    }

    public function getDoi()
    {
        return $this->doi;
    }

    public function setDoi($doi)
    {
        $this->doi = $doi;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getReceived()
    {
        return $this->received;
    }

    public function setReceived($received)
    {
        $this->received = $received;
    }

    public function getAccepted()
    {
        return $this->accepted;
    }

    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setPublished($published)
    {
        $this->published = $published;
    }

    public function getAbstract()
    {
        return $this->abstract;
    }

    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function getTapChi()
    {
        return $this->tapchi;
    }

    public function setTapChi(TapChiVm $tapChiVm)
    {
        $this->tapchi = $tapChiVm;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    public function getIssue()
    {
        return $this->issue;
    }

    public function setIssue($issue)
    {
        $this->issue = $issue;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
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
