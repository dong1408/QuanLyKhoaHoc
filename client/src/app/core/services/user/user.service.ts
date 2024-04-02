import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse, PagingResponse} from "../../types/api-response.type";
import {
    ChangePassword,
    RegisterUser,
    UpdateRole,
    UpdateUser,
    User,
    UserDetail,
    UserVm
} from "../../types/user/user.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {Permission, Role} from "../../types/roles/role.type";

@Injectable({
    providedIn:"root"
})

export class UserService{
    constructor(private http:HttpClient) {

    }

    getAllUsers(keyword:string){
        return this.http.get<ApiResponse<User[]>>(
            `${environment.apiUrl}/users?search=${keyword}`
        ).pipe(
            catchError(handleError)
        )
    }

    getUserPaging(keyword:string,pageIndex:number,isLock:number,sortby:string){
        return this.http.get<ApiResponse<PagingResponse<UserVm[]>>>(
            `${environment.apiUrl}/users/paging?search=${keyword}&page=${pageIndex}&sortby=${sortby}&isLock=${isLock}`
        ).pipe(
            catchError(handleError)
        )
    }

    getUserRole(id:number){
        return this.http.get<ApiResponse<Role[]>>(
            `${environment.apiUrl}/users/${id}/role`
        ).pipe(
            catchError(handleError)
        )
    }

    getUserInfo(){
        return this.http.get<ApiResponse<UserDetail>>(
            `${environment.apiUrl}/users/info`
        ).pipe(
            catchError(handleError)
        )
    }

    // getUserPermission(){
    //     return this.http.get<ApiResponse<Permission[]>>(
    //         `${environment.apiUrl}/users/permission`
    //     ).pipe(
    //         catchError(handleError)
    //     )
    // }

    changePassword(data:ChangePassword){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/users/password`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    registerUser(data:RegisterUser){
        return this.http.post<ApiResponse<boolean>>(
            `${environment.apiUrl}/users`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    updateUser(id:number,data:UpdateUser){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/users/${id}`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    updateRoleUser(id:number,data:UpdateRole){
        return this.http.patch<ApiResponse<Role[]>>(
            `${environment.apiUrl}/users/${id}/role`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    softDeleteUser(id:number){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/users/${id}/delete`,
            null
        ).pipe(
            catchError(handleError)
        )
    }

    restoreUser(id:number){
        return this.http.patch<ApiResponse<boolean>>(
            `${environment.apiUrl}/users/${id}/restore`,
            null
        ).pipe(
            catchError(handleError)
        )
    }

    forceDeleteUser(id:number){
        return this.http.delete<ApiResponse<boolean>>(
            `${environment.apiUrl}/users/${id}/force`
        ).pipe(
            catchError(handleError)
        )
    }

    getUserDetail(id:number){
        return this.http.get<ApiResponse<UserDetail>>(
            `${environment.apiUrl}/users/${id}`
        ).pipe(
            catchError(handleError)
        )
    }

    importUsers(data:FormData){
        return this.http.post<string>(
            `${environment.apiUrl}/users/import`,
            data
        ).pipe(
            catchError(handleError)
        )
    }

    getFileResult(key:string){
        return this.http.get<any>(
            `${environment.apiUrl}/users/export?key=${key}`,{ responseType: 'blob' as 'json' }
        )
    }
}