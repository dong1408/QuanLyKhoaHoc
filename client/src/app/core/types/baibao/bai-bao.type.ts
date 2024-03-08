import {SanPham} from "../sanpham/san-pham.type";
import {Magazine} from "../tapchi/tap-chi.type";

export interface BaiBao{
    id:number,
    tensanpham:string,
    id_sanpham:number,
    doi?:string,
    url?:string,
    received?:string,
    accepted?:string,
    published?:string,
    keywords?:string,
    tentapchi:string,
    volume?:string,
    issue?:string,
    number?:string,
    pages?:string,
    created_at:string,
    updated_at:string,
    deleted_at?:string,
    trangthairasoat?:string

    isSoftDelete:boolean,
    isDelete:boolean,
    isReStore:boolean,
    isChangeStatus:boolean,
}

export interface ChiTietBaiBao{
    id:number,
    sanpham:SanPham,
    doi?:string,
    url?:string,
    received?:string,
    accepted?:string,
    published?:string,
    keywords?:string,
    tapchi:Magazine,
    volume?:string,
    issue?:string,
    number?:string,
    pages?:string,
    created_at:string,
    updated_at:string
    deleted_at?:string,
}