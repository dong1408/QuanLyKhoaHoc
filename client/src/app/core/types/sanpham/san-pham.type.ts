import {DMSanPham} from "./dm-san-pham.type";
import {ToChuc} from "../user-info/to-chuc.type";
import {User} from "../user/user.type";
import {FileMinhChung} from "./file-minh-chung.type";

export interface SanPham{
    id:number,
    tensanpham:string,
    loaisanpham:DMSanPham,
    tongsotacgia:number,
    solandaquydoi?:number,
    cosudungemailtruong?:boolean,
    cosudungemaildonvikhac?:boolean,
    cothongtintruong?:boolean,
    cothongtindonvikhac?:boolean,
    thongtinnoikhac?:ToChuc,
    conhantaitro?:boolean,
    donvitaitro?:ToChuc,
    chitietdonvitaitro?:string,
    ngaykekhai:string,
    nguoikekhai?:User,
    trangthairasoat:string,
    ngayrasoat?:string,
    nguoirasoat?:User,
    diemquydoi?:string,
    gioquydoi?:string,
    thongtinchitiet?:string,
    capsanpham?:string,
    thoidiemcongbohoanthanh?:string,
    minhchung?:FileMinhChung
    created_at:string,
    updated_at:string
}


export interface CapNhatSanPham{
    tensanpham:string,
    tongsotacgia:number,
    solandaquydoi:number,
    cosudungemailtruong:boolean | null,
    cosudungemaildonvikhac:boolean | null,
    cothongtintruong:boolean | null,
    cothongtindonvikhac:boolean | null,
    id_thongtinnoikhac:number  | null,
    conhantaitro:boolean | null,
    id_donvitaitro:number | null,
    chitietdonvitaitro:string | null,
    ngaykekhai:string,
    diemquydoi:string,
    gioquydoi:string,
    thongtinchitiet:string,
    capsanpham:string,
    thoidiemcongbohoanthanh:string
}

export type TrangThaiSanPham = "Đang rà soát" | "Đã xác nhận"

export interface CapNhatTrangThaiSanPham{
    trangthairasoat:TrangThaiSanPham
}

export interface TaoSanPham{
    tensanpham:string,
    tongsotacgia:number,
    conhantaitro:boolean | null,
    id_donvitaitro:number | null,
    chitietdonvitaitro:string | null,
    thoidiemcongbohoanthanh?:string | null
}

export interface TaoFileMinhChung{
    url:string
}