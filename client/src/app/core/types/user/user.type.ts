import {Role} from "../roles/role.type";
import {ToChuc} from "../user-info/to-chuc.type";
import {DonVi} from "../user-info/don-vi.type";
import {NgachVienChuc} from "../user-info/ngach-vien-chuc.type";
import {QuocGia} from "../user-info/quoc-gia.type";
import {HocHamHocVi} from "../user-info/hoc-ham-hoc-vi.type";
import {ChuyenMon} from "../user-info/chuyen-mon.type";
import {NganhTinhDiem} from "../quydoi/nganh-tinh-diem.type";
import {ChuyenNganhTinhDiem} from "../quydoi/chuyen-nganh-tinh-diem.type";

export interface User{
    id:number,
    name:string,
    username:string,
    email:string,
    tochuc:ToChuc,
    hochamhocvi:HocHamHocVi
}

export interface Me{
    id:number,
    name:string,
    username:string,
    email:string,
    roles:Role[],
    changed:boolean
}

export interface UserVm{
    id:number,
    name:string,
    username:string,
    email:string,
    roles:Role[],
    deleted_at?:string,

    roleString:string

    isSoftDelete:boolean,
    isDelete:boolean,
    isRestore:boolean,
}

export interface UserDetail{
    id:number,
    name:string,
    username:string,
    email:string,
    changed:boolean,
    ngaysinh?:string,
    dienthoai?:string,
    email2?:string,
    orchid?:string,
    tochuc?:ToChuc,
    donvi?:DonVi,
    cohuu?:boolean,
    keodai?:boolean,
    dinhmucnghiavunckh?:string,
    dangdihoc?:string,
    noihoc?:ToChuc,
    ngachvienchuc?:NgachVienChuc,
    quoctich?:QuocGia,
    hochamhocvi?:HocHamHocVi,
    chuyenmon?:ChuyenMon,
    nganhtinhdiem?:NganhTinhDiem,
    chuyennganhtinhdiem?:ChuyenNganhTinhDiem,
    created_at:string,
    updated_at:string,
    deleted_at?:string
}

export interface ChangePassword{
    passwordcurrent:string,
    password:string,
    password_confirmation:string
}

export interface RegisterUser{
    name:string,
    username:string,
    email:string,
    ngaysinh:string | null,
    dienthoai:string | null,
    email2:string | null,
    orchid:string | null,
    id_tochuc:number | null,
    id_donvi:number | null,
    cohuu:boolean | null,
    keodai:boolean | null,
    dinhmucnghiavunckh:string | null,
    dangdihoc:string | null,
    id_noihoc:number | null,
    id_ngachvienchuc: number | null,
    id_quoctich: number | null,
    id_hochamhocvi: number | null,
    id_chuyenmon:number | null,
    id_nganhtinhdiem:number | null,
    id_chuyennganhtinhdiem: number | null,
    roles_id:Array<number>
}

export interface UpdateUser{
    name:string,
    // username:string,
    email:string,
    ngaysinh:string | null,
    dienthoai:string | null,
    email2:string | null,
    orchid:string | null,
    id_tochuc:number | null,
    id_donvi:number | null,
    cohuu:boolean | null,
    keodai:boolean | null,
    dinhmucnghiavunckh:string | null,
    dangdihoc:string | null,
    id_noihoc:number | null,
    id_ngachvienchuc: number | null,
    id_quoctich: number | null,
    id_hochamhocvi: number | null,
    id_chuyenmon:number | null,
    id_nganhtinhdiem:number | null,
    id_chuyennganhtinhdiem: number | null,
}

export interface UpdateRole{
    roles_id:Array<number>
}