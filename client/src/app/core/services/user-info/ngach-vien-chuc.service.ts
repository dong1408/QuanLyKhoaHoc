import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {environment} from "../../../../environments/environment";
import {NgachVienChuc} from "../../types/user-info/ngach-vien-chuc.type";

@Injectable({
    providedIn:"root"
})
export class NgachVienChucService{
    constructor(private http:HttpClient) {

    }

    getAllNgachVienChuc(){
        return this.http.get<ApiResponse<NgachVienChuc[]>>(
            `${environment.apiUrl}/ngachvienchuc`
        )
    }
}