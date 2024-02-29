<?php

namespace App\ViewModel\User;

use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\UserInfo\ChuyenMonVm;
use App\ViewModel\UserInfo\DonViVm;
use App\ViewModel\UserInfo\HocHamHocViVm;
use App\ViewModel\UserInfo\NgachVienChucVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\ToChucVm;

class UserVm
{
    private $id;
    private $name;
    private $username;
    private $email;
    // private $password;
    private $role;
    private $changed;
    // private $remember_token
    private $ngaysinh;
    private $dienthoai;
    private $email2;
    private $orchid;
    private $toChucVm; // $id_tochuc
    private $donViVm; // $id_donvi
    private $cohuu;
    private $keodai;
    private $dinhmucnghiavunckh;
    private $dangdihoc;
    private $noiHocVm; // $id_noihoc -- ToChucVm 
    private $ngachVienChucVm; // $id_ngachvienchuc -- NgachVienChucVm
    private $quocTichVm; // $id_quoctich -- QuocGiaVm
    private $hocHamHocViVm; // $id_hochamhocvi
    private $chuyenMonVm; // $id_chuyenmon
    private $nganhTinhDiemVm; // $id_nganhtinhdiem
    private $chuyenNganhTinhDiemVm; // $id_chuyennganhtinhdiem
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

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getUsername()
    {
        return $this->username;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function getRole()
    {
        return $this->role;
    }

    function setRole($role)
    {
        $this->role = $role;
    }

    function getChanged()
    {
        return $this->changed;
    }

    function setChanged($changed)
    {
        $this->changed = $changed;
    }

    function getNgaySinh()
    {
        return $this->ngaysinh;
    }

    function setNgaySinh($ngaysinh)
    {
        $this->ngaysinh = $ngaysinh;
    }

    function getDienThoai()
    {
        return $this->dienthoai;
    }

    function setDienThoai($dienthoai)
    {
        $this->dienthoai = $dienthoai;
    }

    function getEmail2()
    {
        return $this->email2;
    }

    function setEmail2($email2)
    {
        $this->email2 = $email2;
    }

    function getOrchid()
    {
        return $this->orchid;
    }

    function setOrchid($orchid)
    {
        $this->orchid = $orchid;
    }

    function getToChucVm()
    {
        return $this->toChucVm;
    }

    function setToChucVm(ToChucVm $toChucVm)
    {
        $this->toChucVm = $toChucVm;
    }

    function getDonViVm()
    {
        return $this->donViVm;
    }

    function setDonViVm(DonViVm $donViVm)
    {
        $this->donViVm = $donViVm;
    }

    function getCoHuu()
    {
        return $this->cohuu;
    }

    function setCoHuu($cohuu)
    {
        $this->cohuu = $cohuu;
    }

    function getKeoDai()
    {
        return $this->keodai;
    }

    function setKeoDai($keodai)
    {
        $this->keodai = $keodai;
    }

    function getDinhMucNghiaVuNckh()
    {
        return $this->dinhmucnghiavunckh;
    }

    function setDinhMucNghiaVuNckh($dinhmucnghiavunckh)
    {
        $this->dinhmucnghiavunckh = $dinhmucnghiavunckh;
    }

    function getDangDiHoc()
    {
        return $this->dangdihoc;
    }

    function setDangDiHoc($dangdihoc)
    {
        $this->dangdihoc = $dangdihoc;
    }

    function getNoiHocVm()
    {
        return $this->noiHocVm;
    }

    function setNoiHocVm(ToChucVm $noiHocVm)
    {
        $this->noiHocVm = $noiHocVm;
    }

    function getNgachVienChucVm()
    {
        return $this->ngachVienChucVm;
    }

    function setNgachVienChucVm(NgachVienChucVm $ngachVienChucVm)
    {
        $this->ngachVienChucVm = $ngachVienChucVm;
    }

    function getQuocTichVm()
    {
        return $this->quocTichVm;
    }

    function setQuocTichVm(QuocGiaVm $quocTichVm)
    {
        $this->quocTichVm;
    }

    function getHocHamHocViVm()
    {
        return $this->hocHamHocViVm;
    }

    function setHocHamHocVi(HocHamHocViVm $hocHamHocViVm)
    {
        $this->hocHamHocViVm = $hocHamHocViVm;
    }

    function getChuyenMonVm()
    {
        return $this->chuyenMonVm;
    }

    function setChuyenMonVm(ChuyenMonVm $chuyenMonVm)
    {
        $this->chuyenMonVm = $chuyenMonVm;
    }

    function getNganhTinhDiemVm()
    {
        return $this->nganhTinhDiemVm;
    }

    function setNganhTinhDiemVm(NganhTinhDiemVm $nganhTinhDiemVm)
    {
        $this->nganhTinhDiemVm = $nganhTinhDiemVm;
    }

    function getChuyenNganhTinhDiemVm()
    {
        return $this->chuyenNganhTinhDiemVm;
    }

    function setChuyenNganhTinhDiemVm(ChuyenNganhTinhDiemVm $chuyenNganhTinhDiemVm)
    {
        $this->chuyenNganhTinhDiemVm = $chuyenNganhTinhDiemVm;
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
