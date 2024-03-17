import {Component, OnDestroy, OnInit} from "@angular/core";
import {Subject, takeUntil} from "rxjs";
import {Role} from "../../core/types/roles/role.type";
import {RoleService} from "../../core/services/roles/role.service";
import {NzNotificationService} from "ng-zorro-antd/notification";

@Component({
    selector:"app-role-component",
    templateUrl:'./role.component.html',
    styleUrls:['./role.component.css']
})

export class RoleComponent implements OnInit,OnDestroy{

    destroy$ = new Subject<void>()

    roles:Role[] = []

    isLoadingTable: boolean = false


    constructor(
        private roleService:RoleService,
        private notificationService:NzNotificationService
    ) {

    }

    ngOnInit() {
        this.getAllRole()
    }

    getAllRole(){
        this.isLoadingTable = true
        this.roleService.getAllRoles()
            .pipe(takeUntil(this.destroy$))
            .subscribe({
                next:(response) =>{
                    this.roles = response.data
                    this.isLoadingTable = false
                },
                error:(error) =>{
                    this.notificationService.create(
                        'error',
                        'Lỗi',
                        error
                    )

                    this.isLoadingTable = false
                }
            })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}