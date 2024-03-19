import {ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot} from "@angular/router";
import {inject} from "@angular/core";
import {LocalStorageService} from "../services/local-storage.service";
import {AuthService} from "../services/user/auth.service";
import {ACCESS_TOKEN} from "../../shared/commons/constants";
import {catchError, from, of, switchMap} from "rxjs";

export const notChangedGuards:CanActivateFn = (route:ActivatedRouteSnapshot,state:RouterStateSnapshot) => {
    const router = inject(Router)
    const localStorageService = inject(LocalStorageService)
    const authService = inject(AuthService)
    const accessToken = localStorageService.get(ACCESS_TOKEN)
    if(!accessToken){
        router.navigate(["/dang-nhap"])
        return false
    }

    const currentUser = authService.getCurrentUser()
    if(currentUser && !currentUser.changed){
        return true
    }

    return from(authService.getMe()).pipe(
        switchMap((response) => {
            authService.setCurrentUser(response.data)
            authService.userState$.next(response.data)
            if(!response.data.changed){
                return of(true)
            }else{
                router.navigate(["/home/tai-khoan/thong-tin"])
                return of(false)
            }
        }),
        catchError(() => {
            router.navigate(["/dang-nhap"])
            return of(false)
        })
    )
}