import {CapNhatSanPhamUser, SanPham, TaoFileMinhChung, TaoSanPham} from "../sanpham/san-pham.type";
import {SanPhamTacGia, TaoVaiTroTacGia} from "../sanpham/vai-tro-tac-gia.type";
import {KeKhaiChuQuan, KeKhaiHopTac, ToChuc} from "../user-info/to-chuc.type";
import {PhanLoaiDeTai} from "./phan-loai-de-tai.type";


export interface DeTai{
    id:number,
    tensanpham:string,
    id_sanpham:number,
    maso:string,
    ngaydangky?:string,
    capdetai?:string,
    created_at:string,
    updated_at:string,
    deleted_at?:string,
    trangthairasoat:string,
    trangthai:string,

    ///
    isSoftDelete:boolean,
    isDelete:boolean,
    isReStore:boolean,
    isChangeStatus:boolean,
}

export interface ChiTietDeTai{
    id:number,
    sanpham:SanPham,
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
    loaidetai?:PhanLoaiDeTai,
    trangthairasoat:string,
    deleted_at?:string
    created_at:string,
    updated_at:string,
    sanpham_tacgias:SanPhamTacGia[],

    //
    xetduyet?:XetDuyet,
    nghiemthu?:NghiemThu,
    tuyenchon?:TuyenChon
}


export interface BaoCaoTienDo{
    id:number,
    tenbaocao:string,
    ngaynopbaocao?:string,
    ketquaxet?:string,
    thoigiangiahan?:number,
    created_at:string,
    updated_at:string
}

export interface NghiemThu{
    id:number,
    ngaynghiemthu:string,
    ketquanghiemthu:string,
    ngaycongnhanhoanthanh?:string,
    soqdcongnhanhoanthanh?:string,
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

export interface TuyenChon{
    id:number,
    ketquatuyenchon:string,
    lydo?:string,
    created_at:string,
    updated_at:string
}

export type TrangThaiDeTai = "Đủ điều kiện" | "Không đủ điều kiện"

export type STATUS_DE_TAI =
    "Chờ tuyển chọn" |
    "Tuyển chọn thất bại" |
    "Chờ xét duyệt" |
    "Xét duyệt thất bại" |
    "Chờ nghiệm thu" |
    "Nghiệm thu"

export interface XetDuyetDeTai{
    ngayxetduyet:string,
    ketquaxetduyet:TrangThaiDeTai,
    sohopdong:string | null,
    ngaykyhopdong:string | null,
    thoihanhopdong:number | null,
    kinhphi:string | null
}

export interface TuyenChonDeTai{
    ketquatuyenchon:TrangThaiDeTai,
    lydo:string | null
}

export interface NghiemThuDeTai{
    ngaynghiemthu:string,
    ketquanghiemthu:string,
    ngaycongnhanhoanthanh:string | null,
    soqdcongnhanhoanthanh: string | null,
}

export interface BaoCaoTienDoDeTai{
    tenbaocao:string,
    ngaynopbaocao:string,
    ketquaxet:string | null,
    thoigiangiahan:number | null
}

export interface TaoDeTai{
    sanpham:TaoSanPham,
    maso:string,
    ngoaitruong:boolean | null,
    truongchutri:boolean | null,
    tochucchuquan:KeKhaiChuQuan | null,
    id_loaidetai:number | null,
    detaihoptac:boolean | null,
    tochuchoptac:KeKhaiHopTac|  null,
    tylekinhphidonvihoptac:string | null,
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
    tylekinhphidonvihoptac:string | null,
    capdetai: string | null,
    ngaydangky: string | null
}

export interface CapNhatDeTaiUser{
    sanpham:CapNhatSanPhamUser,
    maso:string,
    ngoaitruong:boolean | null,
    truongchutri:boolean | null,
    tochuchoptac:KeKhaiHopTac|  null,
    id_loaidetai:number | null,
    detaihoptac:boolean | null,
    tochucchuquan:KeKhaiChuQuan | null,
    tylekinhphidonvihoptac:string | null,
    capdetai: string | null,
}
