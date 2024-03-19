import {ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot} from "@angular/router";
import {inject} from "@angular/core";
import {AuthService} from "../services/user/auth.service";
import {LocalStorageService} from "../services/local-storage.service";
import {ACCESS_TOKEN} from "../../shared/commons/constants";
import {catchError, from, of, switchMap} from "rxjs";


export const notAuthGuard:CanActivateFn = (route:ActivatedRouteSnapshot, state:RouterStateSnapshot) => {
    const router = inject(Router)
    const localStorageService = inject(LocalStorageService)
    const authService = inject(AuthService)

    const accessToken = localStorageService.get(ACCESS_TOKEN)


    const currentUser = authService.getCurrentUser()
    if(currentUser){
        router.navigate(["/home/tai-khoan/thong-tin"])
        return false
    }

    if(accessToken){
        return from(authService.getMe()).pipe(
            switchMap((response) => {
                authService.setCurrentUser(response.data)
                authService.userState$.next(response.data)
                router.navigate(['/home/tai-khoan/thong-tin'])
                return of(false)
            }),
            catchError(() => {
                return of(true)
            })
        )
    }

    return true
}