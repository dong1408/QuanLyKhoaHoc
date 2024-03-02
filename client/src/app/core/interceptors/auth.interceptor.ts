import {Injectable} from "@angular/core";
import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from "@angular/common/http";
import {catchError, concatMap, Observable, throwError} from "rxjs";
import { environment } from "src/environments/environment";
import {LocalStorageService} from "../services/local-storage.service";
import {AuthService} from "../services/auth.service";
import {ACCESS_TOKEN, REFRESH_TOKEN} from "../../shared/commons/constants";

@Injectable({
    providedIn:"root"
})
export class AuthInterceptor implements HttpInterceptor{
    private allowRoute = [
        `${environment.apiUrl}/auth/login`,
    ]
    private isRetry: boolean = false;

    constructor(private localStorageService: LocalStorageService, private authService: AuthService) {

    }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        let request = req;
        const token = this.localStorageService.get("accessToken")
        const rfToken = this.localStorageService.get("refreshToken")


        if (rfToken !== null) {
            request = request.clone({
                setHeaders: {
                    "RfToken": rfToken
                }
            })
        }

        if ((token === null || token === "") || this.allowRoute.includes(request.url)) {
            return next.handle(request);
        }

        request = this.addTokenToHeader(request, token)

        return next.handle(request).pipe(
            catchError((error) => {
                if (error instanceof HttpErrorResponse && error.status === 401 && !this.isRetry) {
                    return this.handleRefreshToken(request, next)
                }
                return throwError(() => error.error)
            })
        )
    }

    private handleRefreshToken(request: HttpRequest<any>, next: HttpHandler) {
        const refreshToken = this.localStorageService.get("refreshToken")
        if (!this.isRetry) {
            this.isRetry = true


            if (refreshToken) {
                return this.authService.getAccessToken().pipe(
                    concatMap((response: any) => {
                        this.isRetry = false
                        this.localStorageService.set("accessToken", response.data)
                        return next.handle(this.addTokenToHeader(request, response.data))
                    }),
                    catchError((error: any) => {
                        this.isRetry = false
                        this.localStorageService.remove(ACCESS_TOKEN)
                        this.localStorageService.remove(REFRESH_TOKEN)
                        this.authService.userState$.next(null)
                        return throwError(() => error);
                    })
                )
            }
        }
        return next.handle(request)
    }

    private addTokenToHeader(request: HttpRequest<any>, token?: string) {
        let headers = request.headers;

        if (token) {
            headers = headers.set("Authorization", `Bearer ${token}`)
        }

        return request.clone({ headers })
    }
}