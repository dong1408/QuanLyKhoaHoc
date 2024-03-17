import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {CreateRole, Permission, PermissionResponse, Role, UpdateRole} from "../../types/roles/role.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})
export class PermissionService{
    constructor(private http:HttpClient) {

    }

    getAllPermissions(){
        return this.http.get<ApiResponse<PermissionResponse[]>>(
            `${environment.apiUrl}/permissions`
        ).pipe(
            catchError(
                handleError
            )
        )
    }
}