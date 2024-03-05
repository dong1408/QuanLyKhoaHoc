<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\SanPham;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class SanPhamVm
{
    public int $id;
    public string $tensanpham;
    public DMSanPhamVm $loaisanpham; // $id_loaisanpham -- DMSanPhamVm
    public int $tongsotacgia;
    public int $solanquydoi;
    public Boolean $cosudungemailtruong;
    public Boolean $cosudungemaildonvikhac;
    public Boolean $cothongtintruong;
    public Boolean $cothongtindonvikhac;
    public ToChucVm $thongtinnoikhac; // $id_thongtinnoikhac -- ToChucVm
    public Boolean $conhantaitro;
    public ToChucVm $donvitaitro; // $id_donvitaitro -- ToChucVm
    public string $chitietdonvitaitro;
    public string $ngaykekhai;
    public UserVm $nguoikekhai; // $id_nguoikekhai -- UserVm
    public string $trangthairasoat;
    public string $ngayrasoat;
    public UserVm $nguoirasoat; // $id_nguoirasoat -- UserVm
    public string $diemquydoi;
    public string $gioquydoi;
    public string $thongtinchitiet;
    public string $capsanpham;
    public string $thoidiemcongbohoanthanh;
    public string $created_at;
    public string $updated_at;

    private $dmSanPhamVM;
    private $toChucVm;
    private $userVm;

    function __construct()
    {
        $this->dmSanPhamVM = new DMSanPhamVm();
        $this->toChucVm = new ToChucVm();
        $this->userVm = new UserVm();
    }

    public function convert(SanPham $sanPham){
        $this->id;
        $this->tensanpham = $sanPham->tensanpham;
        $this->loaisanpham = $this->dmSanPhamVM->convert($sanPham->dmSanPham);
        $this->tongsotacgia = $sanPham->tongsotacgia;
        $this->solanquydoi = $sanPham->solanquydoi;
        $this->cosudungemailtruong = $sanPham->cosudungemailtruong;
        $this->cosudungemaildonvikhac = $sanPham->cosudungemaildonvikhac;
        $this->cothongtintruong = $sanPham->cothongtintruong;
        $this->cothongtindonvikhac = $sanPham->cothongtindonvikhac;
        $this->thongtinnoikhac = $this->toChucVm->convert($sanPham->thongTinNoiKhac);
        $this->conhantaitro = $sanPham->conhantaitro;
        $this->donvitaitro = $this->toChucVm->convert($sanPham->donViTaiTro);
        $this->chitietdonvitaitro = $sanPham->chitietdonvitaitro;
        $this->ngaykekhai = $sanPham->ngaykekhai;
        $this->nguoikekhai = $this->userVm->convert($sanPham->nguoiKeKhai);
        $this->trangthairasoat = $sanPham->trangthairasoat;
        $this->ngayrasoat = $sanPham->ngayrasoat;
        $this->nguoirasoat = $this->userVm->convert($sanPham->nguoiRaSoat);
        $this->diemquydoi = $sanPham->diemquydoi;
        $this->gioquydoi = $sanPham->gioquydoi;
        $this->thongtinchitiet = $sanPham->thongtinchitiet;
        $this->capsanpham = $sanPham->capsanpham;
        $this->thoidiemcongbohoanthanh = $sanPham->thoidiemcongbohoanthanh;
        $this->created_at = $sanPham->created_at;
        $this->updated_at = $sanPham->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getTenSanPham()
    {
        return $this->tensanpham;
    }

    function setTenSanPham($tensanpham)
    {
        $this->tensanpham = $tensanpham;
    }

    function getLoaiSanPham()
    {
        return $this->loaisanpham;
    }

    function setLoaiSanPham(DMSanPhamVm $loaiSanPhamVm)
    {
        $this->loaisanpham = $loaiSanPhamVm;
    }

    function getTongSoTacGia()
    {
        return $this->tongsotacgia;
    }

    function setTongSoTacGia($tongsotacgia)
    {
        $this->tongsotacgia = $tongsotacgia;
    }

    function getSoLanQuyDoi()
    {
        return $this->solanquydoi;
    }

    function setSoLanQuyDoi($solanquydoi)
    {
        $this->solanquydoi = $solanquydoi;
    }

    function getCoSuDungEmailTruong()
    {
        return $this->cosudungemailtruong;
    }

    function setCoSuDungEmailTruong($cosudungemailtruong)
    {
        $this->cosudungemailtruong = $cosudungemailtruong;
    }

    function getCoSuDungEmailDonViKhac()
    {
        return $this->cosudungemaildonvikhac;
    }

    function setCoSuDungEmailDonViKhac($cosudungemaildonvikhac)
    {
        $this->cosudungemaildonvikhac = $cosudungemaildonvikhac;
    }

    function getCoThongTinTruong()
    {
        return $this->cothongtintruong;
    }

    function setCoThongTinTruong($cothongtintruong)
    {
        $this->cothongtintruong = $cothongtintruong;
    }

    function getCoThongTinDonViKhac()
    {
        return $this->cothongtindonvikhac;
    }

    function setCoThongTinDonViKhac($cothongtindonvikhac)
    {
        $this->cothongtindonvikhac = $cothongtindonvikhac;
    }

    function getThongTinNoiKhac()
    {
        return $this->thongtinnoikhac;
    }

    function setThongTinNoiKhac(ToChucVm $thongTinNoiKhacVm)
    {
        $this->thongtinnoikhac = $thongTinNoiKhacVm;
    }

    function getCoNhanTaiTro()
    {
        return $this->conhantaitro;
    }

    function setCoNhanTaiTro($conhantaitro)
    {
        $this->conhantaitro = $conhantaitro;
    }

    function getDonViTaiTro()
    {
        return $this->donvitaitro;
    }

    function setDonViTaiTro(ToChucVm $donViTaiTroVm)
    {
        $this->donvitaitro = $donViTaiTroVm;
    }

    function getChiTietDonViTaiTro()
    {
        return $this->chitietdonvitaitro;
    }

    function setChiTietDonViTaiTro($chitietdonvitaitro)
    {
        $this->chitietdonvitaitro = $chitietdonvitaitro;
    }

    function getNgayKeKhai()
    {
        return $this->ngaykekhai;
    }

    function setNgayKeKhai($ngaykekhai)
    {
        $this->ngaykekhai = $ngaykekhai;
    }

    function getNguoiKeKhai()
    {
        return $this->nguoikekhai;
    }

    function setNguoiKeKhai(UserVm $nguoiKeKhaiVm)
    {
        $this->nguoikekhai = $nguoiKeKhaiVm;
    }

    function getTrangThaiRaSoat()
    {
        return $this->trangthairasoat;
    }

    function setTrangThaiRaSoat($trangthairasoat)
    {
        $this->trangthairasoat = $trangthairasoat;
    }

    function getNgayRaSoat()
    {
        return $this->ngayrasoat;
    }

    function setNgayRaSoat($ngayrasoat)
    {
        $this->ngayrasoat = $ngayrasoat;
    }

    function getNguoiRaSoat()
    {
        return $this->nguoirasoat;
    }

    function setNguoiRaSoat(UserVm $nguoiRaSoatVm)
    {
        $this->nguoirasoat = $nguoiRaSoatVm;
    }

    function getDiemQuyDoi()
    {
        return $this->diemquydoi;
    }

    function setDiemQuyDoi($diemquydoi)
    {
        $this->diemquydoi = $diemquydoi;
    }

    function getGioQuyDoi()
    {
        return $this->gioquydoi;
    }

    function setGioQuyDoi($gioquydoi)
    {
        $this->gioquydoi = $gioquydoi;
    }

    function getThongTinChiTiet()
    {
        return $this->thongtinchitiet;
    }

    function setThongTinChiTiet($thongtinchitiet)
    {
        $this->thongtinchitiet = $thongtinchitiet;
    }

    function getCapSanPham()
    {
        return $this->capsanpham;
    }

    function setCapSanPham($capsanpham)
    {
        $this->capsanpham = $capsanpham;
    }

    function getThoiDiemCongBoHoanThanh()
    {
        return $this->thoidiemcongbohoanthanh;
    }

    function setThoiDiemCongBoHoanThanh($thoidiemcongbohoanthanh)
    {
        $this->thoidiemcongbohoanthanh = $thoidiemcongbohoanthanh;
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
