import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {concatMap, Subject, takeUntil} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {LocalStorageService} from "../../../core/services/local-storage.service";
import {Router} from "@angular/router";
import {ConstantsService} from "../../../core/services/constants.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {passwordsMatch} from "../../../shared/validators/password-smatch.validator";
import {ChangePassword} from "../../../core/types/user/user.type";
import {UserService} from "../../../core/services/user/user.service";

@Component({
    selector:"app-change-password-component",
    templateUrl:'./change-password.component.html',
    styleUrls:['./change-password.conponent.css']
})

export class ChangePasswordComponent implements OnInit,OnDestroy{

    formChangePassword:FormGroup
    destroy$: Subject<void> = new Subject<void>() // huy nghe observable


    //loading state
    changePasswordLoading:boolean = false

    constructor(
        private fb:FormBuilder,
        private notificationService:NzNotificationService,
        private userService:UserService,
        private localStorageService:LocalStorageService,
        private router:Router,
        public AppConstant:ConstantsService
    ) {

    }

    ngOnInit(){
        this.formChangePassword = this.fb.group({
            passwordcurrent:[
                '',
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            password:[
                '',
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            password_confirmation:[
                '',
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ]
        },{
            validators: passwordsMatch('password','password_confirmation')
        })
    }

    onChangePassword(){
        const form = this.formChangePassword

        if(form.invalid){
            this.notificationService.create(
                'error',
                "Lỗi",
                "Vui lòng nhập đúng yêu cầu của form"
            )

            Object.values(form.controls).forEach(control =>{
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({onlySelf:true})
                }
            })

            return;
        }

        const data:ChangePassword = form.value

        this.changePasswordLoading = true
        this.userService.changePassword(data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.changePasswordLoading = false
                this.router.navigate(["/"])
            },
            error:(response) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    response
                )
                this.changePasswordLoading = false
            }
        })
    }

    ngOnDestroy(): void {
        this.destroy$.next()
        this.destroy$.complete()
    }
}