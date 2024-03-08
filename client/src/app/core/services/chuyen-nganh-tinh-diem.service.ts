import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../types/api-response.type";
import {ChuyenNganhTinhDiem} from "../types/chuyen-nganh-tinh-diem.type";
import {environment} from "../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})

export class ChuyenNganhTinhDiemService{
    constructor(private http:HttpClient) {

    }

    getChuyenNganhTinhDiem(){
        return this.http.get<ApiResponse<ChuyenNganhTinhDiem[]>>(`${environment.apiUrl}/chuyennganhtinhdiem`)
            .pipe(
                catchError(handleError)
            )
    }

    getChuyenNganhTinhDiemByIdNganhTinhDiem(id:number){
        return this.http.get<ApiResponse<ChuyenNganhTinhDiem[]>>(`${environment.apiUrl}/chuyennganhtinhdiem/${id}/nganhtinhdiem`)
            .pipe(
                catchError(handleError)
            )
    }
}