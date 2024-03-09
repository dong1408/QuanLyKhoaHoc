import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {NganhTinhDiem} from "../../types/quydoi/nganh-tinh-diem.type";
import {environment} from "../../../../environments/environment";
import {handleError} from "../../../shared/commons/handler-error-http";
import {catchError} from "rxjs";

@Injectable({
    providedIn:"root"
})
export class NganhTinhDiemService{
    constructor(private http:HttpClient) {
    }

    getNganhTinhDiem(){
        return this.http.get<ApiResponse<NganhTinhDiem[]>>(`${environment.apiUrl}/nganhtinhdiem`)
            .pipe(
                catchError(handleError)
            )
    }
}