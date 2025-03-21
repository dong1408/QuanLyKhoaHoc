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
    updated_at:string,


    //
    isDelete:boolean
}

export interface TaoToChuc{
    matochuc:string | null,
    tentochuc:string,
    tentochuc_en:string | null,
    website: string | null,
    dienthoai: string | null,
    address: string | null,
    id_address_city: number | null,
    id_address_country: number | null,
    id_phanloaitochuc: number | null
}

export interface CapNhatToChuc{
    matochuc:string | null,
    tentochuc:string,
    tentochuc_en:string | null,
    website: string | null,
    dienthoai: string | null,
    address: string | null,
    id_address_city: number | null,
    id_address_country: number | null,
    id_phanloaitochuc: number | null
}

export interface ChiTietToChuc{
    id:number,
    matochuc?:string,
    tentochuc?:string,
    tentochuc_en?:string,
    website?:string,
    dienthoai?:string,
    addresscity?:TinhThanh,
    addresscountry?:QuocGia,
    phanloaitochuc?:PhanLoaiToChuc,
    address?:string

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

export interface KeKhaiToChuc{
    id_tochuc:number | null,
    tentochuc:string
}

export interface KeKhaiDonVi{
    id_donvi:number | null,
    tentochuc:string
}

export interface KeKhaiChuQuan{
    id_tochucchuquan:number | null,
    tentochuc:string
}

export interface KeKhaiHopTac{
    id_tochuchoptac:number | null,
    tentochuc:string
}