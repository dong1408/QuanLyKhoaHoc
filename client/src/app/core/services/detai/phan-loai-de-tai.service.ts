import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {PhanLoaiDeTai} from "../../types/detai/phan-loai-de-tai.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})

export class PhanLoaiDeTaiService{
    constructor(private http:HttpClient) {

    }

    getPhanLoaiDeTai(){
        return this.http.get<ApiResponse<PhanLoaiDeTai[]>>(
            `${environment.apiUrl}/phanloaidetai`
        ).pipe(
            catchError(handleError)
        )
    }
}