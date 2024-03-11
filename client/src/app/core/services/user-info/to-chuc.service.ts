import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {ToChuc} from "../../types/user-info/to-chuc.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})
export class ToChucService{
    constructor(private http:HttpClient) {

    }

    getAllToChuc(){
        return this.http.get<ApiResponse<ToChuc[]>>(`${environment.apiUrl}/tochuc`)
            .pipe(
                catchError(handleError)
            )
    }
}