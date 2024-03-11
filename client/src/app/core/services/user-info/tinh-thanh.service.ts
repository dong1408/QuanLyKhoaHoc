import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {TinhThanh} from "../../types/user-info/tinh-thanh.type";

@Injectable({
    providedIn:"root"
})
export class TinhThanhService{
    constructor(private http:HttpClient) {

    }

    getAllTinhThanh(){
        return this.http.get<ApiResponse<TinhThanh[]>>(`${environment.apiUrl}/tinhthanh`)
            .pipe(
                catchError(handleError)
            )
    }

    getAllTinhThanhByQuocGia(id:number){
        return this.http.get<ApiResponse<TinhThanh[]>>(`${environment.apiUrl}/tinhthanh/${id}/quocgia`)
            .pipe(
                catchError(handleError)
            )
    }
}