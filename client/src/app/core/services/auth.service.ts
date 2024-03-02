import {Injectable} from "@angular/core";
import {BehaviorSubject, catchError, Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {User} from "../types/user.type";
import {ApiResponse} from "../types/api-response.type";
import {environment} from "../../../environments/environment";
import {handleError} from "../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})
export class AuthService{
    userState$:BehaviorSubject<any> = new BehaviorSubject<any>(null)
    user:User | null = null

    constructor(private http:HttpClient) {

    }

    getCurrentUser():User | null{
        return this.user
    }

    setCurrentUser(user: User | null){
        this.user = user;
    }

    getMe():Observable<ApiResponse<User>>{
        return this.http.get<ApiResponse<User>>(`${environment.apiUrl}/auth/me`).pipe(
            catchError(handleError)
        )
    }

    getAccessToken():Observable<ApiResponse<string>> {
        return this.http.post<ApiResponse<string>>(`${environment.apiUrl}/auth/refresh`,{})
    }
}