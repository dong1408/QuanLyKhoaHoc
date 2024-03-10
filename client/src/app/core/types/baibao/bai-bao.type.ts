import {SanPham} from "../sanpham/san-pham.type";
import {Magazine} from "../tapchi/tap-chi.type";
import {SanPhamTacGia, TaoVaiTroTacGia} from "../sanpham/vai-tro-tac-gia.type";

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
    abstract?:string,
    sanpham_tacgias:SanPhamTacGia[]
}

//create cả sản phẩm trong bài báo luôn, quan hệ 1-1

export interface TaoSanPham{
    tensanpham:string,
    id_loaisanpham:number,
    tongsotacgia:number,
    solandaquydoi:number,
    cosudungemailtruong:boolean | null,
    cosudungemaildonvikhac:boolean | null,
    cothongtintruong:boolean | null,
    cothongtindonvikhac:boolean | null,
    id_thongtinnoikhac:number  | null,
    conhantaitro:boolean | null,
    id_donvitaitro:number | null,
    chitietdonvitaitro:string | null,
    ngaykekhai:string,
    id_nguoikekhai:number,
    diemquydoi:string,
    gioquydoi:string,
    thongtinchitiet:string,
    capsanpham:string,
    thoidiemcongbohoanthanh:string
}

//tạo cẩ bảng vai trò tác giả trong sản phẩm


//tạo luôn bang file minh chứng
export interface TaoFileMinhChung{
    loaiminhchung:string | null,
    url:string
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
    keywords:string | null,
    id_tapchi:number,
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