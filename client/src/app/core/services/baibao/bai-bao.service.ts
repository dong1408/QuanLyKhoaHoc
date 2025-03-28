import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse, PagingResponse} from "../../types/api-response.type";
import {
    BaiBao,
    CapNhatBaiBao,
    CapNhatBaiBaoUser,
    ChiTietBaiBao,
    TaoBaiTao
} from "../../types/baibao/bai-bao.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {CapNhatSanPham, CapNhatTrangThaiSanPham} from "../../types/sanpham/san-pham.type";
import {CapNhatVaiTroTacGia, SanPhamTacGia} from "../../types/sanpham/vai-tro-tac-gia.type";
import {CapNhatFileMinhChung, FileVm} from "../../types/sanpham/file-minh-chung.type";

@Injectable({
    providedIn:"root"
})

export class BaiBaoService{
    constructor(private http:HttpClient) {

    }

    getBaiBao(page:number,keyword:string,sortby:string,islock:number){
        return this.http.get<ApiResponse<PagingResponse<BaiBao[]>>>(
            `${environment.apiUrl}/baibao?page=${page}&search=${keyword}&sortby=${sortby}&isLock=${islock}`
        ).pipe(
            catchError(handleError)
        )
    }

    getBaiBaoChoDuyet(page:number,keyword:string,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<BaiBao[]>>>(
            `${environment.apiUrl}/baibao/choduyet?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getBaiBaoKeKhai(page:number,keyword:string,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<BaiBao[]>>>(
            `${environment.apiUrl}/baibao/kekhai?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getBaiBaoThamGia(page:number,keyword:string,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<BaiBao[]>>>(
            `${environment.apiUrl}/baibao/thamgia?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getChiTietBaiBao(id:number){
        return this.http.get<ApiResponse<ChiTietBaiBao>>(
            `${environment.apiUrl}/baibao/${id}`
        ).pipe(
            catchError(handleError)
        )
    }

    taoBaiBao(data:TaoBaiTao){
        return this.http.post<ApiResponse<BaiBao>>(
            `${environment.apiUrl}/baibao`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatBaiBao(id:number,data:CapNhatBaiBao){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/baibao/${id}`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatSanPham(id:number,data:CapNhatSanPham){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/baibao/${id}/sanpham`,
            data
        )
    }

    xoaMemBaiBao(id:number){
        return this.http.patch<ApiResponse<boolean>>(`${environment.apiUrl}/baibao/${id}/delete`,null).pipe(
            catchError(handleError)
        )
    }

    xoaBaiBao(id:number){
        return this.http.delete<ApiResponse<boolean>>(`${environment.apiUrl}/baibao/${id}/force`).pipe(
            catchError(handleError)
        )
    }

    hoanTacXoaBaiBao(id:number){
        return this.http.patch<ApiResponse<boolean>>(`${environment.apiUrl}/baibao/${id}/restore`,null).pipe(
            catchError(handleError)
        )
    }

    capNhatVaiTroTacGia(id:number,data:CapNhatVaiTroTacGia){
        return this.http.patch<ApiResponse<SanPhamTacGia[]>>(
            `${environment.apiUrl}/baibao/${id}/sanphamtacgia`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatFileMinhChung(id:number,data:FormData){
        return this.http.post<ApiResponse<string>>(
            `${environment.apiUrl}/baibao/${id}/fileminhchung`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    uploadFileMinhChung(data:FormData){
        return this.http.post<ApiResponse<FileVm>>(
            `${environment.apiUrl}/baibao/fileminhchung`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    capNhatTrangThaiSanPham(id:number,data:CapNhatTrangThaiSanPham){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/baibao/${id}/trangthairasoat`,
            data
        ).pipe(
            catchError(handleError)
        )
    }


    capNhatBaiBaoChoNguoiDung(id:number,data:CapNhatBaiBaoUser){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/baibao/public/${id}`,
            data
        ).pipe(
            catchError(handleError)
        )
    }
}