import {ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot} from "@angular/router";
import {catchError, from, of, switchMap} from "rxjs";
import {inject} from "@angular/core";
import {LocalStorageService} from "../services/local-storage.service";
import {AuthService} from "../services/user/auth.service";
import {ACCESS_TOKEN} from "../../shared/commons/constants";

export const adminGuards:CanActivateFn = (route:ActivatedRouteSnapshot,state:RouterStateSnapshot) => {
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
        if(!currentUser.changed){
            router.navigate(["/doi-mat-khau"])
            return false
        }
        return currentUser.roles.some((item) => {
            return item.mavaitro === "admin" || "super_admin"
        })
    }

    return from(authService.getMe()).pipe(
        switchMap((response) => {
            authService.setCurrentUser(response.data)
            authService.userState$.next(response.data)

            if(!response.data.changed){
                router.navigate(["/doi-mat-khau"])
                return of(false)
            }
            return of(
                response.data.roles.some((item) => {
                    return item.mavaitro === "admin" || "super_admin"
                })
            )
        }),
        catchError(() => {
            router.navigate(["/dang-nhap"])
            return of(false)
        })
    )
}