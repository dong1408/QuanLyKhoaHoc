import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {Keyword} from "../../types/baibao/keyword.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})

export class KeywordService{
    constructor(private http:HttpClient) {

    }

    getAllKeyword(keyword:string){
        return this.http.get<ApiResponse<Keyword[]>>(
            `${environment.apiUrl}/keywords?search=${keyword}`
        ).pipe(
            catchError(handleError)
        )
    }
}