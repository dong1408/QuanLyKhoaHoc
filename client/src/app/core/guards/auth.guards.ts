import {ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot} from "@angular/router";
import {catchError, from, of, switchMap} from "rxjs";
import {inject} from "@angular/core";
import {LocalStorageService} from "../services/local-storage.service";
import {AuthService} from "../services/auth.service";
import {ACCESS_TOKEN} from "../../shared/commons/constants";

export const authGuards:CanActivateFn = (route:ActivatedRouteSnapshot,state:RouterStateSnapshot) => {
    const router = inject(Router)
    const localStorageService = inject(LocalStorageService)
    const authService = inject(AuthService)
    const accessToken = localStorageService.get(ACCESS_TOKEN)
    if(!accessToken){
        router.navigate(["/dang-nhap"])
        return false
    }
    const currentUser = authService.getCurrentUser()
    if(currentUser){
        return true
    }

    return from(authService.getMe()).pipe(
        switchMap((response) => {
            authService.setCurrentUser(response.data)
            return of(true)
        }),
        catchError(() => {
            return of(false)
        })
    )
}