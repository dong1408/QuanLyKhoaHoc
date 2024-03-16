import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {ChiTietRole, CreateRole, Role, UpdateRole} from "../../types/roles/role.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";

@Injectable({
    providedIn:"root"
})
export class RoleService{
    constructor(private http:HttpClient) {

    }

    getAllRoles(){
        return this.http.get<ApiResponse<Role[]>>(
            `${environment.apiUrl}/roles`
        ).pipe(
            catchError(
                handleError
            )
        )
    }

    createRole(data:CreateRole){
        return this.http.post<ApiResponse<boolean>>(
            `${environment.apiUrl}/roles`,
            data
        ).pipe(
            catchError(
                handleError
            )
        )
    }

    getChiTietRole(id:number){
        return this.http.get<ApiResponse<ChiTietRole>>(
            `${environment.apiUrl}/roles/${id}`
        ).pipe(
            catchError(
                handleError
            )
        )
    }

    updateRole(id:number,data:UpdateRole){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/roles/${id}`,
            data
        ).pipe(
            catchError(
                handleError
            )
        )
    }
}