import {ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot} from "@angular/router";
import {inject} from "@angular/core";
import {AuthService} from "../services/auth.service";
import {LocalStorageService} from "../services/local-storage.service";
import {ACCESS_TOKEN} from "../../shared/commons/constants";


export const notAuthGuard:CanActivateFn = (route:ActivatedRouteSnapshot, state:RouterStateSnapshot) => {
    const router = inject(Router)
    const localStorageService = inject(LocalStorageService)
    const authService = inject(AuthService)

    const accessToken = localStorageService.get(ACCESS_TOKEN)

    if(accessToken){
        router.navigate(["/"])
        return false
    }

    const currentUser = authService.getCurrentUser()
    if(currentUser){
        router.navigate(["/"])
        return false
    }

    return true
}