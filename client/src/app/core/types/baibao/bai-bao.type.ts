import {SanPham, TaoFileMinhChung, TaoSanPham} from "../sanpham/san-pham.type";
import {KeKhaiTapChi, Magazine} from "../tapchi/tap-chi.type";
import {SanPhamTacGia, TaoVaiTroTacGia} from "../sanpham/vai-tro-tac-gia.type";
import {KeKhaiKeyword, Keyword} from "./keyword.type";

export interface BaiBao{
    id:number,
    tensanpham:string,
    id_sanpham:number,
    doi?:string,
    url?:string,
    received?:string,
    accepted?:string,
    published?:string,
    tentapchi:string,
    volume?:string,
    issue?:string,
    number?:string,
    pages?:string,
    created_at:string,
    updated_at:string,
    deleted_at?:string,
    trangthairasoat?:string,

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
    tapchi:Magazine,
    volume?:string,
    issue?:string,
    number?:string,
    pages?:string,
    created_at:string,
    updated_at:string
    deleted_at?:string,
    abstract?:string,
    sanpham_tacgias:SanPhamTacGia[],
    keywords:Keyword[] | null
}



export interface TaoBaiTao{
    sanpham:TaoSanPham,
    fileminhchungsanpham:TaoFileMinhChung,
    sanpham_tacgia:TaoVaiTroTacGia[],
    doi:string  | null,
    url:string  | null,
    received:string  | null,
    accepted:string  | null,
    published:string | null ,
    abstract:string | null,
    keywords?:KeKhaiKeyword[],
    tapchi:KeKhaiTapChi,
    volume:string  | null,
    issue:string | null,
    number:string | null,
    pages:string | null
}


export interface CapNhatBaiBao{
    doi:string  | null,
    url:string  | null,
    received:string  | null,
    accepted:string  | null,
    published:string | null ,
    abstract:string | null,
    keywords:string | null,
    id_tapchi:number,
    volume:string  | null,
    issue:string | null,
    number:string | null,
    pages:string | null
}