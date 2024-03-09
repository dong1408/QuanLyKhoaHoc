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