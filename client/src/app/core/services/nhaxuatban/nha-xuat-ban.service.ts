import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {ApiResponse} from "../../types/api-response.type";
import {ToChuc} from "../../types/user-info/to-chuc.type";
import {environment} from "../../../../environments/environment";
import {catchError} from "rxjs";
import {handleError} from "../../../shared/commons/handler-error-http";
import {QuocGia} from "../../types/user-info/quoc-gia.type";
import {NhaXuatBan} from "../../types/nhaxuatban/nha-xuat-ban.type";

@Injectable({
    providedIn:"root"
})
export class NhaXuatBanService{
    constructor(private http:HttpClient) {

    }

    getAllNhaXuatBan(){
        return this.http.get<ApiResponse<NhaXuatBan[]>>(`${environment.apiUrl}/nhaxuatban`)
            .pipe(
                catchError(handleError)
            )
    }
}