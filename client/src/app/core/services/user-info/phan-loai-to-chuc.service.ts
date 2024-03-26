import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {TinhThanh} from "../../types/user-info/tinh-thanh.type";
import {PhanLoaiToChuc} from "../../types/user-info/to-chuc.type";

@Injectable({
    providedIn:"root"
})
export class PhanLoaiToChucService{
    constructor(private http:HttpClient) {

    }

    getAllPhanLoaiToChuc(){
        return this.http.get<ApiResponse<PhanLoaiToChuc[]>>(`${environment.apiUrl}/phanloaitochuc`)
            .pipe(
                catchError(handleError)
            )
    }
}