import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../types/api-response.type";
import {PhanLoaiTapChi} from "../types/phan-loai-tap-chi.type";
import {environment} from "../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})
export class PhanLoaiTapChiService{
    constructor(private http:HttpClient) {

    }

    getPhanLoaiTapChi(){
        return this.http.get<ApiResponse<PhanLoaiTapChi[]>>(`${environment.apiUrl}/phanloaitapchi`)
            .pipe(
                catchError(handleError)
            )
    }
}