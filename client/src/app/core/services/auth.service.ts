import {Injectable} from "@angular/core";
import {BehaviorSubject} from "rxjs";
import {HttpClient} from "@angular/common/http";

@Injectable({
    providedIn:"root"
})
export class AuthService{
    userState$:BehaviorSubject<any> = new BehaviorSubject<any>(null)
    constructor(private http:HttpClient) {

    }
}