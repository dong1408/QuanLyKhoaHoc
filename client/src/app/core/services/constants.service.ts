import {Injectable} from "@angular/core";
import {TrangThaiSanPham} from "../types/sanpham/san-pham.type";
import {STATUS_DE_TAI, TrangThaiDeTai} from "../types/detai/de-tai.type";

@Injectable({
    providedIn:"root"
})

export class ConstantsService{
    readonly TT_DANG_RA_SOAT:TrangThaiSanPham = "Đang rà soát"
    readonly TT_DA_XAC_NHAN:TrangThaiSanPham = "Đã xác nhận"
    readonly TT_DETAI_FAILED:TrangThaiDeTai = "Không đủ điều kiện"
    readonly TT_DETAI_SUCCESS:TrangThaiDeTai = "Đủ điều kiện"

    // STATUS

    readonly  NGHIEM_THU: STATUS_DE_TAI = "Nghiệm thu"
    readonly CHO_NGHIEM_THU : STATUS_DE_TAI = "Chờ nghiệm thu"
    readonly CHO_XET_DUYET : STATUS_DE_TAI = "Chờ xét duyệt"
    readonly  CHO_TUYEN_CHON : STATUS_DE_TAI = "Chờ tuyển chọn"
    readonly TUYEN_CHON_THAT_BAI : STATUS_DE_TAI = "Tuyển chọn thất bại"
    readonly XET_DUYET_THAT_BAI : STATUS_DE_TAI ="Xét duyệt thất bại"

    readonly MA_VAI_TRO = [
        {
            name:"Super Admin",
            value:"super_admin"
        },
        {
            name:"Admin",
            value:"admin"
        },
        {
            name:"Giảng Viên",
            value:"giangvien"
        },
        {
            name:"Sinh Viên",
            value:"sinhvien"
        },
        {
            name:"Guest",
            value:"guest"
        },
    ]

    readonly DE_TAI_FILTER = [
        {
            name: "Tất Cả",
            value:"all"
        },
        {
            name:"Chờ Tuyển Chọn", // sản phẩm Đã rà soát
            value:"cho_tuyen_chon"
        },
        {
            // tuyển chọn thất bại
            name:"Tuyển Chọn Thất Bại",
            value:"tuyen_chon_that_bai"
        },
        {
            name:"Chờ Xét Duyệt", // tuyển chọn thành công
            value:"cho_xet_duyet"
        },
        {
            name:"Xét Duyệt Thất Bại",
            value:"xet_duyet_that_bai"
        },
        {
            name:"Chờ Nghiệm Thu",
            value:"cho_nghiem_thu"
        },
        {
            name:"Nghiệm Thu", // xong rồi
            value:"nghiem_thu"
        }
    ]
}