import {ActivatedRouteSnapshot, CanActivateFn, RouterStateSnapshot} from "@angular/router";
import {of} from "rxjs";

export const authGuards:CanActivateFn = (route:ActivatedRouteSnapshot,state:RouterStateSnapshot) => {
    return of(true)
}