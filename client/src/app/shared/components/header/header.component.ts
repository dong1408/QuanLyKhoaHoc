import {Component} from "@angular/core";
import {Me} from "../../../core/types/user/user.type";
import {Subject, takeUntil} from "rxjs";
import {AuthService} from "../../../core/services/user/auth.service";
import {LocalStorageService} from "../../../core/services/local-storage.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {Router} from "@angular/router";
import {ConstantsService} from "../../../core/services/constants.service";

@Component({
    selector:"app-header",
    templateUrl:"./header.component.html",
    styleUrls:["./header.component.css"]
})

export class HeaderComponent{
    visibleMenu:boolean = false

    userInfo: Me | null = null

    destroy$: Subject<void> = new Subject<void>()

    logoutLoading:boolean = false

    constructor(
        private authService:AuthService,
        private localStorageService:LocalStorageService,
        private notificationService:NzNotificationService,
        private router:Router,
        public AppConstant:ConstantsService
    ) {

    }

    ngOnInit() {
        this.authService.userState$.pipe(takeUntil(this.destroy$)).subscribe(response => {
            this.userInfo = response
        })
    }

    logout(){
        this.logoutLoading = true
        this.authService.logout().pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    "success",
                    "Thành Công",
                    response.message
                )
                this.localStorageService.clear()
                this.authService.userState$.next(null)
                this.logoutLoading = false
                window.location.href  = "/dang-nhap"
            },
            error:(error) => {
                this.notificationService.create(
                    "error",
                    "Lỗi",
                    error
                )
            }
        })
    }


    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }

    onMenu(){
        this.visibleMenu = !this.visibleMenu
    }
}