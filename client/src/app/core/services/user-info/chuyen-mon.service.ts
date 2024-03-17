import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {environment} from "../../../../environments/environment";
import {ChuyenMon} from "../../types/user-info/chuyen-mon.type";

@Injectable({
    providedIn:"root"
})
export class ChuyenMonService{
    constructor(private http:HttpClient) {

    }

    getAllChuyeMon(){
        return this.http.get<ApiResponse<ChuyenMon[]>>(
            `${environment.apiUrl}/chuyenmon`
        )
    }
}