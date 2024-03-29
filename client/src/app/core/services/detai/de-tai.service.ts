import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse, PagingResponse} from "../../types/api-response.type";
import {
    BaoCaoTienDo,
    BaoCaoTienDoDeTai,
    CapNhatDeTai, CapNhatDeTaiUser,
    ChiTietDeTai,
    DeTai, NghiemThu, NghiemThuDeTai,
    TaoDeTai,
    TuyenChon,
    TuyenChonDeTai, XetDuyet,
    XetDuyetDeTai
} from "../../types/detai/de-tai.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {CapNhatSanPham, CapNhatTrangThaiSanPham} from "../../types/sanpham/san-pham.type";
import {CapNhatVaiTroTacGia, SanPhamTacGia} from "../../types/sanpham/vai-tro-tac-gia.type";
import {CapNhatFileMinhChung, FileVm} from "../../types/sanpham/file-minh-chung.type";

@Injectable({
    providedIn:"root"
})

export class DeTaiService{
    constructor(private http:HttpClient) {

    }

    getDeTais(keyword:string,pageIndex:number,sortby:string,isLock:number,filter:string){
        return this.http.get<ApiResponse<PagingResponse<DeTai[]>>>(
            `${environment.apiUrl}/detai?search=${keyword}&page=${pageIndex}&sortby=${sortby}&isLock=${isLock}&filter=${filter}`
        ).pipe(
            catchError(handleError)
        )
    }

    getDeTaiChoDuyet(page:number,keyword:string,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<DeTai[]>>>(
            `${environment.apiUrl}/detai/choduyet?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getDeTaiThamGia(page:number,keyword:string,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<DeTai[]>>>(
            `${environment.apiUrl}/detai/thamgia?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getDeTaiKeKhai(page:number,keyword:string,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<DeTai[]>>>(
            `${environment.apiUrl}/detai/kekhai?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getChiTietDeTai(id:number){
        return this.http.get<ApiResponse<ChiTietDeTai>>(
            `${environment.apiUrl}/detai/${id}`
        ).pipe(
            catchError(handleError)
        )
    }

    taoDeTai(data:TaoDeTai){
        return this.http.post<ApiResponse<DeTai>>(
            `${environment.apiUrl}/detai`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatDeTai(id:number,data:CapNhatDeTai){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/detai/${id}`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatDeTaiChoNguoiDung(id:number,data:CapNhatDeTaiUser){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/detai/public/${id}`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatSanPham(id:number,data:CapNhatSanPham){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/detai/${id}/sanpham`,
            data
        )
    }

    xoaMemDeTai(id:number){
        return this.http.patch<ApiResponse<boolean>>(`${environment.apiUrl}/detai/${id}/delete`,null).pipe(
            catchError(handleError)
        )
    }

    xoaDeTai(id:number){
        return this.http.delete<ApiResponse<boolean>>(`${environment.apiUrl}/detai/${id}/force`).pipe(
            catchError(handleError)
        )
    }

    hoanTacXoaDeTai(id:number){
        return this.http.patch<ApiResponse<boolean>>(`${environment.apiUrl}/detai/${id}/restore`,null).pipe(
            catchError(handleError)
        )
    }

    capNhatVaiTroTacGia(id:number,data:CapNhatVaiTroTacGia){
        return this.http.patch<ApiResponse<SanPhamTacGia[]>>(
            `${environment.apiUrl}/detai/${id}/sanphamtacgia`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatFileMinhChung(id:number,data:FormData){
        return this.http.post<ApiResponse<string>>(
            `${environment.apiUrl}/detai/${id}/fileminhchung`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatTrangThaiSanPham(id:number,data:CapNhatTrangThaiSanPham){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/detai/${id}/trangthairasoat`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    tuyenChonDeTai(id:number,data:TuyenChonDeTai){
        return this.http.post<ApiResponse<TuyenChon>>(
            `${environment.apiUrl}/detai/${id}/tuyenchon`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    xetDuyetDeTai(id:number,data:XetDuyetDeTai){
        return this.http.post<ApiResponse<XetDuyet>>(
            `${environment.apiUrl}/detai/${id}/xetduyet`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    baoCaoTienDoDeTai(id:number,data:BaoCaoTienDoDeTai){
        return this.http.post<ApiResponse<BaoCaoTienDo>>(
            `${environment.apiUrl}/detai/${id}/baocao`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    nghiemThuDeTai(id:number,data:NghiemThuDeTai){
        return this.http.post<ApiResponse<NghiemThu>>(
            `${environment.apiUrl}/detai/${id}/nghiemthu`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    getLichSuBaoCaoDeTai(id:number,pageIndex:number){
        return this.http.get<ApiResponse<PagingResponse<BaoCaoTienDo[]>>>(
            `${environment.apiUrl}/detai/${id}/lichsubaocao?page=${pageIndex}`
        )
    }

    uploadFileMinhChung(data:FormData){
        return this.http.post<ApiResponse<FileVm>>(
            `${environment.apiUrl}/detai/fileminhchung`,
            data
        ).pipe(
            catchError(handleError)
        )
    }
}