import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {VaiTroTacGia} from "../../types/sanpham/vai-tro-tac-gia.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})

export class VaiTroService{
    constructor(private http:HttpClient) {

    }

    getVaiTroBaiBao(){
        return this.http.get<ApiResponse<VaiTroTacGia[]>>(`${environment.apiUrl}/vaitro/baibao`)
            .pipe(
                catchError(handleError)
            )
    }

    getVaiTroDeTai(){
        return this.http.get<ApiResponse<VaiTroTacGia[]>>(`${environment.apiUrl}/vaitro/detai`)
            .pipe(
                catchError(handleError)
            )
    }
}