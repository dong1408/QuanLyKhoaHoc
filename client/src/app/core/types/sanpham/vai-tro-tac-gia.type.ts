import {User} from "../user/user.type";

export interface VaiTroTacGia{
    id:number,
    tenvaitro:string,
    tenvaitro_en?:string,
    mota?:string,
    created_at:string,
    updated_at:string
}

export interface SanPhamTacGia{
    id:number,
    tacgia:User,
    vaitrotacgia:VaiTroTacGia,
    thutu?:string,
    tyledonggop?:string,
    created_at:string,
    updated_at:string
}

export interface TaoVaiTroTacGia{
    id_tacgia:number,
    id_vaitro:number,
    thutu:string | null,
    tyledonggop:string | null,
}

export interface CapNhatVaiTroTacGia{
    sanpham_tacgia:TaoVaiTroTacGia[]
}