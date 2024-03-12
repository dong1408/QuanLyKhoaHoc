import {TaoFileMinhChung, TaoSanPham} from "../sanpham/san-pham.type";
import {TaoVaiTroTacGia} from "../sanpham/vai-tro-tac-gia.type";
import {ToChuc} from "../user-info/to-chuc.type";
import {PhanLoaiDeTai} from "./phan-loai-de-tai.type";


export interface DeTai{
    id:number,
    tensanpham:string,
    id_sanpham:number,
    trangthai:string,
    maso:string,
    ngaydangky?:string,
    capdetai?:string,
    created_at:string,
    updated_at:string,
    deleted_at?:string

    ///
    isSoftDelete:boolean,
    isDelete:boolean,
    isReStore:boolean,
    isChangeStatus:boolean,
}

export interface ChiTietDeTai{
    id:number,
    tensanpham:string,
    id_sanpham:number,
    trangthai:string,
    maso:string,
    ngaydangky?:string,
    capdetai?:string,
    ngoaitruong?:boolean,
    truongchutri?:boolean,
    tochucchuquan?:ToChuc,
    detaihoptac?:boolean,
    tochuchoptac?:ToChuc,
    tylekinhphidonvihoptac?:string,
    created_at:string,
    updated_at:string,
    loaidetai:PhanLoaiDeTai
}


export interface BaoBaoTienDo{
    id:number,
    ngaynopbaocao?:string,
    ketquanhanxet?:string,
    thoigiangiahan?:string,
    created_at:string,
    updated_at:string
}

export interface NghiemThu{
    id:number,
    hoidongnghiemthu?:string,
    ngaynghiemthu?:string,
    ketquanghiemthu?:string,
    ngaycongnhanhoanthanh?:string,
    soqdcongnhanhoanthanh?:string,
    thoigianhoanthanh?:string,
    created_at:string,
    updated_at:string
}

export interface XetDuyet{
    id:number,
    ngayxetduyet?:string,
    ketquaxetduyet?:string,
    sohopdong?:string,
    ngaykyhopdong?:string,
    thoihanhopdong?:string,
    kinhphi?:string,
    created_at:string,
    updated_at:string
}

export interface TaoDeTai{
    sanpham:TaoSanPham,
    maso:string,
    ngoaitruong:boolean | null,
    truongchutri:boolean | null,
    id_tochucchuquan:number | null,
    id_loaidetai:number | null,
    detaihoptac:boolean | null,
    id_tochuchoptac:number|  null,
    tylekinphidonvihoptac:string | null,
    capdetai: string | null,
    sanpham_tacgia:TaoVaiTroTacGia[],
    fileminhchungsanpham:TaoFileMinhChung
}

export interface CapNhatDeTai{
    maso:string,
    ngoaitruong:boolean | null,
    truongchutri:boolean | null,
    id_tochucchuquan:number | null,
    id_loaidetai:number | null,
    detaihoptac:boolean | null,
    id_tochuchoptac:number|  null,
    tylekinphidonvihoptac:string | null,
    capdetai: string | null,
    ngaydangky: string | null
}

