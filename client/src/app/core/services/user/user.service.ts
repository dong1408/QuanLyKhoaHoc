import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {User} from "../../types/user/user.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})

export class UserService{
    constructor(private http:HttpClient) {

    }

    getAllUsers(keyword:string){
        return this.http.get<ApiResponse<User[]>>(
            `${environment.apiUrl}/users?search=${keyword}`
        ).pipe(
            catchError(handleError)
        )
    }
}