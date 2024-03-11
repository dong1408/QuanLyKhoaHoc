import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {ToChuc} from "../../types/user-info/to-chuc.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {QuocGia} from "../../types/user-info/quoc-gia.type";

@Injectable({
    providedIn:"root"
})
export class QuocGiaService{
    constructor(private http:HttpClient) {

    }

    getAllQuocGia(){
        return this.http.get<ApiResponse<QuocGia[]>>(`${environment.apiUrl}/quocgia`)
            .pipe(
                catchError(handleError)
            )
    }
}