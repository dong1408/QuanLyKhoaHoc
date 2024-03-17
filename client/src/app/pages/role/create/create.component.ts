import {Component, OnDestroy, OnInit} from "@angular/core";
import {Subject, takeUntil} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {CreateRole, Permission, PermissionResponse, Role} from "../../../core/types/roles/role.type";
import {RoleService} from "../../../core/services/roles/role.service";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {PermissionService} from "../../../core/services/roles/permission.service";
import {LoadingService} from "../../../core/services/loading.service";
import {ConstantsService} from "../../../core/services/constants.service";
import {Router} from "@angular/router";

@Component({
    selector:"app-role-create",
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class CreateRoleComponent implements OnInit,OnDestroy{

    destroy$ = new Subject<void>()


    detai_permissions:Permission[] = []
    nguoidung_permissions:Permission[] = []
    baibao_permissions:Permission[] = []
    role_permissions:Permission[] = []
    permissions:Permission[] = []

    createForm:FormGroup

    isCreate:boolean = false


    constructor(
        private roleService:RoleService,
        private notificationService:NzNotificationService,
        private fb:FormBuilder,
        private permissionService:PermissionService,
        public loadingService:LoadingService,
        public AppConstant:ConstantsService,
        private router:Router
    ) {

    }

    ngOnInit() {
        this.createForm = this.fb.group({
            name:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator(),
                ])
            ],
            description:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            mavaitro:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            detai_id:[
                []
            ],
            baibao_id:[
                []
            ],
            nguoidung_id:[
                []
            ],
            role_id:[
                []
            ]
        })

        this.getAllPermission()
    }

    getAllPermission(){
        this.loadingService.startLoading()
        this.permissionService.getAllPermissions()
            .pipe(takeUntil(this.destroy$))
            .subscribe({
                next:(response) =>{

                    response.data.forEach(item => {
                        if(item.prefixSlug === "detai"){
                            this.detai_permissions = item.permissions
                        }
                        if(item.prefixSlug === "user"){
                            this.nguoidung_permissions = item.permissions
                        }
                        if(item.prefixSlug === "role"){
                            this.role_permissions = item.permissions
                        }
                        if(item.prefixSlug === "baibao"){
                            this.baibao_permissions= item.permissions
                        }
                        if(item.prefixSlug === "permission"){
                            this.permissions = item.permissions
                        }
                    })

                    this.loadingService.stopLoading()
                },
                error:(error) =>{
                    this.notificationService.create(
                        'error',
                        'Lỗi',
                        error
                    )
                    this.loadingService.stopLoading()
                    this.router.navigate(['/vai-tro'])
                    return;
                }
            })
    }

    onSubmit(){
        const form = this.createForm
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

        const permission_id = [
            ...form.get("detai_id")?.value,
            ...form.get("nguoidung_id")?.value,
            ...form.get("baibao_id")?.value,
            ...form.get("role_id")?.value,
        ]

        if(permission_id.length <= 0){
            this.notificationService.create(
                'error',
                "Lỗi",
                "Vui lòng chọn quyền cho vai trò mới"
            )
            return;
        }

        const data:CreateRole = {
            name: form.get("name")?.value,
            mavaitro: form.get("mavaitro")?.value,
            permission_id : permission_id,
            description : form.get("description")?.value ?? null
        }

        console.log(data)
        this.isCreate = true
        this.roleService.createRole(data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )

                this.createForm.reset()
                this.isCreate = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isCreate = false
            }
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}