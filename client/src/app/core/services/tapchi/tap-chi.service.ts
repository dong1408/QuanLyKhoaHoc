import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse, PagingResponse} from "../../types/api-response.type";
import {
    ChiTietTapChi, CreateTapChi,
    Magazine,
    MagazineRecognize,
    TinhDiemTapChi, UpdateKhongCongNhan,
    UpdateTapChi, UpdateTinhDiem,
    UpdateTrangThaiTapChi, UpdateXepHang,
    XepHangTapChi
} from "../../types/tapchi/tap-chi.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})

export class TapChiService{
    constructor(
        private http:HttpClient
    ) {

    }

    getChiTietTapChi(id:number){
        return this.http.get<ApiResponse<ChiTietTapChi>>(
            `${environment.apiUrl}/tapchi/${id}/detail`
        ).pipe(
            catchError(handleError)
        )
    }

    getTapChiPaging(page:number,keyword:string,sortby:string,islock:number){
        return this.http.get<ApiResponse<PagingResponse<Magazine[]>>>(
            `${environment.apiUrl}/tapchi/paging?page=${page}&search=${keyword}&sortby=${sortby}&isLock=${islock}`
        ).pipe(
            catchError(handleError)
        )
    }

    getTapChiChoDuyetPaging(page:number,keyword:string,sortby:string,){
        return this.http.get<ApiResponse<PagingResponse<Magazine[]>>>(
            `${environment.apiUrl}/tapchi/choduyet/paging?page=${page}&search=${keyword}&sortby=${sortby}`
        ).pipe(
            catchError(handleError)
        )
    }

    getTapChiKhongCongNhan(id:number,page:number){
        return this.http.get<ApiResponse<PagingResponse<MagazineRecognize[]>>>(
            `${environment.apiUrl}/tapchi/${id}/khongcongnhan?page=${page}`
        ).pipe(
            catchError(handleError)
        )
    }

    getXepHangTapChi(id:number,page:number){
        return this.http.get<ApiResponse<PagingResponse<XepHangTapChi[]>>>(
            `${environment.apiUrl}/tapchi/${id}/xephang?page=${page}`
        ).pipe(
            catchError(handleError)
        )
    }

    getTapChiTinhDiem(id:number,page:number){
        return this.http.get<ApiResponse<PagingResponse<TinhDiemTapChi[]>>>(
            `${environment.apiUrl}/tapchi/${id}/tinhdiem?page=${page}`
        ).pipe(
            catchError(handleError)
        )
    }

    updateTrangThaiTapChi(id:number,data:UpdateTrangThaiTapChi){
        return this.http.patch<ApiResponse<Boolean>>(
            `${environment.apiUrl}/tapchi/${id}/trangthai`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    updateTapChi(id:number,data:UpdateTapChi){
        return this.http.patch<ApiResponse<Boolean>>(
            `${environment.apiUrl}/tapchi/${id}`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    updateKhongCongNhan(id:number,data:UpdateKhongCongNhan){
        return this.http.post<ApiResponse<MagazineRecognize>>(
            `${environment.apiUrl}/tapchi/${id}/khongcongnhan`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    updateXepHang(id:number,data:UpdateXepHang){
        return this.http.post<ApiResponse<XepHangTapChi>>(
            `${environment.apiUrl}/tapchi/${id}/xephang`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    updateTinhDiem(id:number,data:UpdateTinhDiem){
        return this.http.post<ApiResponse<TinhDiemTapChi>>(
            `${environment.apiUrl}/tapchi/${id}/tinhdiem`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    softDeleteTapChi(id:number){
        return this.http.patch<ApiResponse<Boolean>>(
            `${environment.apiUrl}/tapchi/${id}/delete`,null
        ).pipe(
            catchError(handleError)
        )
    }

    forceDeleteTapChi(id:number){
        return this.http.delete<ApiResponse<Boolean>>(
            `${environment.apiUrl}/tapchi/${id}/force`
        ).pipe(
            catchError(handleError)
        )
    }

    restoreTapChi(id:number){
        return this.http.patch<ApiResponse<Boolean>>(
            `${environment.apiUrl}/tapchi/${id}/restore`,
            null
        ).pipe(
            catchError(handleError)
        )
    }

    createTapChi(data:CreateTapChi){
        return this.http.post<ApiResponse<Magazine>>(
            `${environment.apiUrl}/tapchi`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    getAllTapChi(keyword:string){
        return this.http.get<ApiResponse<Magazine[]>>(
            `${environment.apiUrl}/tapchi?search=${keyword}`
        ).pipe(
            catchError(handleError)
        )
    }
}