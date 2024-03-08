import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../types/api-response.type";
import {ToChuc} from "../types/to-chuc.type";
import {environment} from "../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../shared/commons/handler-error-http";
import {HoiDongGiaoSu} from "../types/hoi-dong-giao-su.type";

@Injectable({
    providedIn:"root"
})
export class HoiDongGiaoSuService{
    constructor(private http:HttpClient) {

    }

    getAllHDGS(){
        return this.http.get<ApiResponse<HoiDongGiaoSu[]>>(`${environment.apiUrl}/hdgs`)
            .pipe(
                catchError(handleError)
            )
    }
}