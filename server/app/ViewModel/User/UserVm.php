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
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class UserVm
{
    public Integer $id;
    public string $name;
    public string $username;
    public string $email;
    // public $password;
    public Integer $role;
    public Boolean $changed;
    // public $remember_token
    public string $ngaysinh;
    public string $dienthoai;
    public string $email2;
    public string $orchid;
    public ToChucVm $tochuc; // $id_tochuc
    public DonViVm $donvi; // $id_donvi
    public Boolean $cohuu;
    public Boolean $keodai;
    public string $dinhmucnghiavunckh;
    public string $dangdihoc;
    public ToChucVm $noihoc; // $id_noihoc -- ToChucVm 
    public NgachVienChucVm $ngachvienchuc; // $id_ngachvienchuc -- NgachVienChucVm
    public QuocGiaVm $quoctich; // $id_quoctich -- QuocGiaVm
    public HocHamHocViVm $hochamhocvi; // $id_hochamhocvi
    public ChuyenMonVm $chuyenmon; // $id_chuyenmon
    public NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem
    public ChuyenNganhTinhDiemVm $chuyennganhtinhdiem; // $id_chuyennganhtinhdiem
    public string $created_at;
    public string $updated_at;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
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

    function getToChuc()
    {
        return $this->tochuc;
    }

    function setToChuc(ToChucVm $toChucVm)
    {
        $this->tochuc = $toChucVm;
    }

    function getDonVi()
    {
        return $this->donvi;
    }

    function setDonVi(DonViVm $donViVm)
    {
        $this->donvi = $donViVm;
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

    function getNoiHoc()
    {
        return $this->noihoc;
    }

    function setNoiHoc(ToChucVm $noiHocVm)
    {
        $this->noihoc = $noiHocVm;
    }

    function getNgachVienChuc()
    {
        return $this->ngachvienchuc;
    }

    function setNgachVienChuc(NgachVienChucVm $ngachVienChucVm)
    {
        $this->ngachvienchuc = $ngachVienChucVm;
    }

    function getQuocTich()
    {
        return $this->quoctich;
    }

    function setQuocTich(QuocGiaVm $quocTichVm)
    {
        $this->quoctich;
    }

    function getHocHamHocVi()
    {
        return $this->hochamhocvi;
    }

    function setHocHamHocVi(HocHamHocViVm $hocHamHocViVm)
    {
        $this->hochamhocvi = $hocHamHocViVm;
    }

    function getChuyenMon()
    {
        return $this->chuyenmon;
    }

    function setChuyenMon(ChuyenMonVm $chuyenMonVm)
    {
        $this->chuyenmon = $chuyenMonVm;
    }

    function getNganhTinhDiem()
    {
        return $this->nganhtinhdiem;
    }

    function setNganhTinhDiem(NganhTinhDiemVm $nganhTinhDiemVm)
    {
        $this->nganhtinhdiem = $nganhTinhDiemVm;
    }

    function getChuyenNganhTinhDiem()
    {
        return $this->chuyennganhtinhdiem;
    }

    function setChuyenNganhTinhDiem(ChuyenNganhTinhDiemVm $chuyenNganhTinhDiemVm)
    {
        $this->chuyennganhtinhdiem = $chuyenNganhTinhDiemVm;
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
