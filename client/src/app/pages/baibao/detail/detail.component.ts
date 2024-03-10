import {Component} from "@angular/core";
import {ChiTietTapChi, UpdateTrangThaiTapChi} from "../../../core/types/tapchi/tap-chi.type";
import {Subject, takeUntil} from "rxjs";
import {FormBuilder} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {BaiBao, ChiTietBaiBao} from "../../../core/types/baibao/bai-bao.type";
import {BaiBaoService} from "../../../core/services/baibao/bai-bao.service";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../../core/types/sanpham/san-pham.type";

@Component({
    selector:"app-baibao-chitiet",
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class ChiTietBaiBaoComponent{
    id:number

    isRestore:boolean = false
    isForceDelete:boolean = false
    isSoftDelete:boolean = false
    isChangeStatus:boolean = false
    isDelete:boolean = false

    baibao:ChiTietBaiBao

    destroy$ = new Subject<void>()
    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private baiBaoService:BaiBaoService,
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
                this.router.navigate(["/tap-chi"])
                return;
            }
        })

        this.getChiTietBaiBao()
    }


    getChiTietBaiBao(){
        this.loadingService.startLoading()
        this.baiBaoService.getChiTietBaiBao(this.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao = response.data
                this.loadingService.stopLoading()
                console.log(response.data)
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.loadingService.stopLoading()
                this.router.navigate(['/bai-bao'])
                return;
            }
        })
    }

    onXoaMemBaiBao(baiBao:ChiTietBaiBao){
        this.isSoftDelete = true;
        this.baiBaoService.xoaMemBaiBao(baiBao.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                baiBao.deleted_at = Date.now().toString()
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

    onXoaBaiBao(baiBao:ChiTietBaiBao){
        this.isDelete = true;
        this.baiBaoService.xoaBaiBao(baiBao.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isDelete = false
                this.router.navigate(['/bai-bao'])
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isDelete = false
            }
        })
    }

    onCapNhatTrangThai(baiBao:ChiTietBaiBao,trangthai:TrangThaiSanPham){
        this.isChangeStatus = true;

        const data:CapNhatTrangThaiSanPham = {
            trangthairasoat: trangthai
        }

        this.baiBaoService.capNhatTrangThaiSanPham(baiBao.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao.sanpham.trangthairasoat = trangthai

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

    onHoanTacXoaBaiBao(baiBao:ChiTietBaiBao){
        this.isRestore = true;
        this.baiBaoService.hoanTacXoaBaiBao(baiBao.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao.deleted_at = undefined
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


    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}