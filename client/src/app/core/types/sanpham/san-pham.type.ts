import {DMSanPham} from "./dm-san-pham.type";
import {ToChuc} from "../user-info/to-chuc.type";
import {User} from "../user/user.type";

export interface SanPham{
    id:number,
    tensanpham:string,
    loaisanpham:DMSanPham,
    tongsotacgia:number,
    solanquydoi:number,
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
    diemquydoi:string,
    gioquydoi:string,
    thongtinchitiet:string,
    capsanpham:string,
    thoidiemcongbohoanthanh:string,
    created_at:string,
    updated_at:string
}