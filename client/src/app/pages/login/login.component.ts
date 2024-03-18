import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {HttpClient} from "@angular/common/http";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {concatMap, forkJoin, of, Subject, takeUntil} from "rxjs";
import {Login} from "../../core/types/user/auth.type";
import {AuthService} from "../../core/services/user/auth.service";
import {LocalStorageService} from "../../core/services/local-storage.service";
import {ACCESS_TOKEN, REFRESH_TOKEN} from "../../shared/commons/constants";
import {Router} from "@angular/router";
import {ConstantsService} from "../../core/services/constants.service";

@Component({
    selector:'app-login',
    templateUrl:'./login.component.html',
    styleUrls:['./login.component.css']
})
export class LoginComponent implements OnInit,OnDestroy{

    formLogin:FormGroup
    destroy$: Subject<void> = new Subject<void>() // huy nghe observable


    //loading state
    loginLoading:boolean = false

    constructor(
        private fb:FormBuilder,
        private notificationService:NzNotificationService,
        private authService:AuthService,
        private localStorageService:LocalStorageService,
        private router:Router,
        public AppConstant:ConstantsService
    ) {

    }

    ngOnInit(){
        this.formLogin = this.fb.group({
            username:[
                '',
                Validators.compose([
                    Validators.required
                ])
            ],
            password:[
                '',
                Validators.compose([
                    Validators.required
                ])
            ]
        })
    }

    onLogin(){
        const data:Login = this.formLogin.value

        this.loginLoading = true
        this.authService.login(data).pipe(
            takeUntil(this.destroy$),
            concatMap((response) => {
                this.localStorageService.set(ACCESS_TOKEN,response.data.accessToken)
                this.localStorageService.set(REFRESH_TOKEN,response.data.refreshToken)

                return this.authService.getMe()
            })
        ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    "Đăng nhập thành công"
                )
                this.authService.userState$.next(response.data)
                this.authService.setCurrentUser(response.data)
                this.loginLoading = false
                this.router.navigate(["/"])
            },
            error:(response) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    response
                )
                this.loginLoading = false
            }
        })
    }

    ngOnDestroy(): void {
        this.destroy$.next()
        this.destroy$.complete()
    }
}