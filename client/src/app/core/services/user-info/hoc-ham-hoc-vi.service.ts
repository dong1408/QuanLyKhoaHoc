import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {environment} from "../../../../environments/environment";
import {HocHamHocVi} from "../../types/user-info/hoc-ham-hoc-vi.type";

@Injectable({
    providedIn:"root"
})
export class HocHamHocViService{
    constructor(private http:HttpClient) {

    }

    getAllHocHamHocVi(){
        return this.http.get<ApiResponse<HocHamHocVi[]>>(
            `${environment.apiUrl}/hochamhocvi`
        )
    }
}