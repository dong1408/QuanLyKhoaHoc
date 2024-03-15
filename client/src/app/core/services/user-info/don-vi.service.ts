import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {DonVi} from "../../types/user-info/don-vi.type";
import {environment} from "../../../../environments/environment";

@Injectable({
    providedIn:"root"
})
export class DonViService{
    constructor(private http:HttpClient) {

    }

    getAllDonVi(){
        return this.http.get<ApiResponse<DonVi[]>>(
            `${environment.apiUrl}/donvi`
        )
    }

    getAllByToChucId(id:number){
        return this.http.get<ApiResponse<DonVi[]>>(
            `${environment.apiUrl}/donvi/${id}/tochuc`
        )
    }
}