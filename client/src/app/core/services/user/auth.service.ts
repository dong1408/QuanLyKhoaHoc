import {Injectable} from "@angular/core";
import {BehaviorSubject, catchError, Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {Me, User} from "../../types/user/user.type";
import {ApiResponse} from "../../types/api-response.type";
import {environment} from "../../../../environments/environment";
import {handleError} from "../../../shared/commons/handler-error-http";
import {Login, Token} from "../../types/user/auth.type";

@Injectable({
    providedIn:"root"
})
export class AuthService{
    userState$:BehaviorSubject<any> = new BehaviorSubject<any>(null)
    user:Me | null = null

    constructor(private http:HttpClient) {

    }

    getCurrentUser():Me | null{
        return this.user
    }

    setCurrentUser(user: Me | null){
        this.user = user;
    }

    getMe():Observable<ApiResponse<Me>>{
        return this.http.get<ApiResponse<Me>>(`${environment.apiUrl}/auth/getMe`).pipe(
            catchError(handleError)
        )
    }

    getAccessToken():Observable<ApiResponse<Token>> {
        return this.http.post<ApiResponse<Token>>(`${environment.apiUrl}/auth/refreshToken`,{}).pipe(
            catchError(handleError)
        )
    }

    login(login:Login):Observable<ApiResponse<Token>> {
        return this.http.post<ApiResponse<Token>>(`${environment.apiUrl}/auth/login`,login).pipe(
            catchError(handleError)
        )
    }

    logout():Observable<ApiResponse<string>> {
        return this.http.post<ApiResponse<string>>(`${environment.apiUrl}/auth/logout`,{}).pipe(
            catchError(handleError)
        )
    }
}