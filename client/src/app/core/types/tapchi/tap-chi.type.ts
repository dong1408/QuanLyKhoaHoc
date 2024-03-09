import {User} from "../user/user.type";
import {NganhTinhDiem} from "../quydoi/nganh-tinh-diem.type";
import {ChuyenNganhTinhDiem} from "../quydoi/chuyen-nganh-tinh-diem.type";
import {ToChuc} from "../user-info/to-chuc.type";
import {Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";

export interface Magazine{
    id:number,
    name?:string,
    quocte?:boolean,
    address?:string,
    trangthai:boolean,
    nguoithem?:User,
    created_at:string,
    updated_at:string,
    deleted_at?:string,
    issn?:string,
    pissn?:string,
    eissn?:string,
    //
    isSoftDelete:boolean,
    isDelete:boolean,
    isReStore:boolean,
    isChangeStatus:boolean,
}

export interface ChiTietTapChi{
    id:number,
    name?:string,
    quocte?:boolean,
    website?:string,
    address?:string,
    trangthai:boolean,
    created_at:string,
    updated_at:string,
    deleted_at?:string,
    issn?:string,
    pissn?:string,
    eissn?:string,
    nguoithem?:User,
    khongduoccongnhan?:MagazineRecognize,
    xephangtapchi?:XepHangTapChi,
    tinhdiemtapchi?:TinhDiemTapChi,
    donvichuquan?:ToChuc
}

export interface CreateTapChi{
    name:string,
    issn?:string,
    pissn?:string,
    eissn?:string,
    website?:string,
    quocte?:boolean,
    id_nhaxuatban?:number,
    id_donvichuquan:number,
    address?:string,
    id_address_city?:number,
    id_address_country?:number,
    trangthai:boolean
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

export interface XepHangTapChi{
    id:number,
    wos?:string,
    if?:string,
    quartile?:string,
    abs?:string,
    abcd?:string,
    aci?:string,
    ghichu?:string,
    nguoicapnhat:User,
    created_at:string,
    updated_at:string
}

export interface UpdateTrangThaiTapChi{
    trangthai:boolean
}

export interface UpdateTapChi{
    name:string,
    issn?:string,
    eissn?:string,
    pissn?:string,
    website?:string,
    quocte?:boolean,
    id_nhaxuatban?:number,
    id_donvichuquan?:number,
    address?:string,
    id_address_city?:number,
    id_adress_country?:number,
    dmphanloaitapchi?:Array<number>,
    dmnganhtheohdgs?:Array<number>
}

export interface UpdateKhongCongNhan{
    khongduoccongnhan?:boolean,
    ghichu?:boolean
}

export interface UpdateXepHang{
    wos?:string,
    if?:string,
    quartile?:string,
    abs?:string,
    abcd?:string,
    aci?:string,
    ghichu?:string,
    dmphanloaitapchi?:Array<number>
    // con thieu id cua phan muc xep hang gi a' scopus, aci...
}


export interface UpdateTinhDiem{
    id_nganhtinhdiem:number,
    id_chuyennganhtinhdiem:number,
    diem?:string,
    namtinhdiem?:string
    ghichu?:string
}


