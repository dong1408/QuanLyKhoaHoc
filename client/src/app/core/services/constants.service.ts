import {Injectable} from "@angular/core";
import {TrangThaiSanPham} from "../types/sanpham/san-pham.type";

@Injectable({
    providedIn:"root"
})

export class ConstantsService{
    readonly TT_DANG_RA_SOAT:TrangThaiSanPham = "Đang rà soát"
    readonly TT_DA_XAC_NHAN:TrangThaiSanPham = "Đã xác nhận"
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
            value:"xet_duyet_that_Bai"
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