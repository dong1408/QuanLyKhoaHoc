import {User} from "./user.type";
import {NganhTinhDiem} from "./nganh-tinh-diem.type";
import {ChuyenNganhTinhDiem} from "./chuyen-nganh-tinh-diem.type";

export interface Magazine{
    id:number,
    name?:string,
    quocte?:boolean,
    address?:string,
    trangthai:boolean,
    nguoithem?:User,
    created_at:string,
    updated_at:string
}

export interface MagazineRecognize{
    id:number,
    khongduoccongnhan?:boolean,
    ghichu?:string,
    nguoicapnhat?:User,
    created_at:string,
    updated_at:string,
}

export interface TinhDiemTapChi{
    id:number,
    diem?:string,
    namtinhdiem?:string,
    nguoicapnhat?:User,
    ghichu?:string,
    created_at:string,
    updated_at:string,
    nganhtinhdiem:NganhTinhDiem,
    chuyennganhtinhdiem:ChuyenNganhTinhDiem
}