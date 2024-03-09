import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse, PagingResponse} from "../../types/api-response.type";
import {BaiBao, ChiTietBaiBao} from "../../types/baibao/bai-bao.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

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

    getChiTietBaiBao(id:number){
        return this.http.get<ApiResponse<PagingResponse<ChiTietBaiBao>>>(
            `${environment.apiUrl}/baibao/${id}`
        ).pipe(
            catchError(handleError)
        )
    }

    taoBaiBao(){

    }

    capNhatBaiBao(){

    }

    capNhatSanPham(){

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
}