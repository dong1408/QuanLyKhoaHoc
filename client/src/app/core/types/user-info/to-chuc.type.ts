import {TinhThanh} from "./tinh-thanh.type";
import {QuocGia} from "./quoc-gia.type";

export interface ToChuc{
    id:number,
    matochuc?:string,
    tentochuc?:string,
    tentochuc_en?:string,
    website?:string,
    dienthoai?:string,
    created_at:string,
    updated_at:string
}

export interface PhanLoaiToChuc{
    id:number,
    maloai:string,
    tenloai:string,
    tenloai_en:string,
    created_at:string,
    updated_at:string
}