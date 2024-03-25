import {User} from "../user/user.type";
import {KeKhaiToChuc, ToChuc} from "../user-info/to-chuc.type";
import {HocHamHocVi} from "../user-info/hoc-ham-hoc-vi.type";

export interface VaiTroTacGia{
    id:number,
    tenvaitro:string,
    tenvaitro_en?:string,
    mavaitro:string,
    role:string,
    created_at:string,
    updated_at:string
}

export interface SanPhamTacGia{
    id:number,
    tacgia:User,
    vaitrotacgia:VaiTroTacGia,
    thutu?:number,
    tyledonggop?:number,
    tochuc?:ToChuc,
    hochamhocvi?:HocHamHocVi,
    email:string,
    dienthoai?:string,
    ngaysinh?:string,
    created_at:string,
    updated_at:string
}

export interface TaoVaiTroTacGia{
    id_tacgia:number,
    id_vaitro:number,
    thutu:string | null,
    tyledonggop:string | null,
    tentacgia:string,
    tochuc:KeKhaiToChuc
}

export interface CapNhatVaiTroTacGia{
    sanpham_tacgia:TaoVaiTroTacGia[]
}