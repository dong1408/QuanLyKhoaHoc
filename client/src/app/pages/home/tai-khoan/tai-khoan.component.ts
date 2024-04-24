import {Component, NgModule, OnDestroy, OnInit} from "@angular/core";
import {Me} from "../../../core/types/user/user.type";
import {Subject, takeUntil} from "rxjs";
import {AuthService} from "../../../core/services/user/auth.service";
import {ConstantsService} from "../../../core/services/constants.service";

@Component({
    selector:'app-tai-khoan',
    templateUrl:'./tai-khoan.component.html',
    styleUrls:['./tai-khoan.component.css']
})

export class TaiKhoanComponent implements OnInit,OnDestroy{
    userInfo: Me | null = null

    destroy$: Subject<void> = new Subject<void>()

    constructor(
        private authService:AuthService,
        public AppConstant:ConstantsService
    ) {

    }

    ngOnInit() {
        this.authService.userState$.pipe(takeUntil(this.destroy$)).subscribe(response => {
            this.userInfo = response
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}