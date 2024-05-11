import {Component, OnDestroy, OnInit} from "@angular/core";
import {NzModalService} from "ng-zorro-antd/modal";
import {FormBuilder} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {NganhTinhDiemService} from "../../../core/services/quydoi/nganh-tinh-diem.service";
import {ChuyenNganhTinhDiemService} from "../../../core/services/quydoi/chuyen-nganh-tinh-diem.service";
import {Subject, takeUntil} from "rxjs";
import {ChiTietTapChi, Magazine, UpdateTrangThaiTapChi} from "../../../core/types/tapchi/tap-chi.type";

@Component({
    selector:'app-magazine-detail',
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class MagazineDetailComponent implements OnInit,OnDestroy{

    id:number

    isRestore:boolean = false
    isForceDelete:boolean = false
    isSoftDelete:boolean = false
    isChangeStatus:boolean = false

    magazine:ChiTietTapChi

    destroy$ = new Subject<void>()
    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private tapChiService:TapChiService,
        private notificationService:NzNotificationService,
        private _router: ActivatedRoute,
        private router:Router,
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/tap-chi"])
                return;
            }
        })

        this.getChiTietTapChi()
    }


    getChiTietTapChi(){
        this.loadingService.startLoading()
        this.tapChiService.getChiTietTapChi(this.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.magazine = response.data
                this.loadingService.stopLoading()
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.loadingService.stopLoading()
                this.router.navigate(['/admin/admin/tap-chi'])
                return;
            }
        })
    }

    onRestoreMagazine(magazine:ChiTietTapChi){
        this.isRestore = true;
        this.tapChiService.restoreTapChi(magazine.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                magazine.deleted_at = undefined
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isRestore = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isRestore = false
            }
        })
    }

    onChangeStatusTapChi(magazine:ChiTietTapChi,trangthai:boolean){
        this.isChangeStatus = true

        const data:UpdateTrangThaiTapChi = {
            trangthai: trangthai
        }

        this.tapChiService.updateTrangThaiTapChi(magazine.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                magazine.trangthai = trangthai

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isChangeStatus = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isChangeStatus = false
            }
        })
    }

    onForceDeleteMagazine(magazine:ChiTietTapChi){
        this.isForceDelete = true
        this.tapChiService.forceDeleteTapChi(magazine.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isForceDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isForceDelete = false
            }
        })
    }

    onSoftDeleteMagazine(magazine:ChiTietTapChi){
        this.isSoftDelete = true;
        this.tapChiService.softDeleteTapChi(magazine.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                magazine.deleted_at = Date.now().toString()

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isSoftDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isSoftDelete = false
            }
        })
    }


    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }

}