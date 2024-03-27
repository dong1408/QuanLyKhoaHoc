import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse, PagingResponse} from "../../types/api-response.type";
import {CapNhatToChuc, ChiTietToChuc, TaoToChuc, ToChuc} from "../../types/user-info/to-chuc.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})
export class ToChucService{
    constructor(private http:HttpClient) {

    }

    getAllToChuc(keyword:string){
        return this.http.get<ApiResponse<ToChuc[]>>(`${environment.apiUrl}/tochuc?search=${keyword}`)
            .pipe(
                catchError(handleError)
            )
    }

    getChiTietToChuc(id:number){
        return this.http.get<ApiResponse<ChiTietToChuc>>(`${environment.apiUrl}/tochuc/${id}`)
            .pipe(
                catchError(handleError)
            )
    }

    getToChucPaging(pageIndex:number,keyword:string,sortBy:string){
        return this.http.get<ApiResponse<PagingResponse<ToChuc[]>>>(`${environment.apiUrl}/tochuc/paging?search=${keyword}&page=${pageIndex}&sortby=${sortBy}`)
            .pipe(
                catchError(handleError)
            )
    }
    
    taoToChuc(data:TaoToChuc){
        return this.http.post<ApiResponse<ToChuc>>(`${environment.apiUrl}/tochuc`,data)
            .pipe(
                catchError(handleError)
            )
    }
    
    capNhatToChuc(id:number,data:CapNhatToChuc){
        return this.http.patch<ApiResponse<ToChuc>>(`${environment.apiUrl}/tochuc/${id}`,data)
            .pipe(
                catchError(handleError)
            )
    }
    
    xoaToChuc(id:number){
        return this.http.delete<ApiResponse<boolean>>(`${environment.apiUrl}/tochuc/${id}`)
            .pipe(
                catchError(handleError)
            )
    }
}