import {Component, OnDestroy, OnInit} from "@angular/core";
import {NzModalService} from "ng-zorro-antd/modal";
import {FormBuilder} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {TapChiService} from "../../../core/services/tap-chi.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {NganhTinhDiemService} from "../../../core/services/nganh-tinh-diem.service";
import {ChuyenNganhTinhDiemService} from "../../../core/services/chuyen-nganh-tinh-diem.service";
import {Subject, takeUntil} from "rxjs";
import {ChiTietTapChi} from "../../../core/types/tap-chi.type";

@Component({
    selector:'app-magazine-detail',
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class MagazineDetailComponent implements OnInit,OnDestroy{

    id:number

    magazine:ChiTietTapChi

    destroy$ = new Subject<void>()
    constructor(
        private modal: NzModalService,
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private tapChiService:TapChiService,
        private notificationService:NzNotificationService,
        private _router: ActivatedRoute,
        private router:Router,
        private nganhTinhDiemService:NganhTinhDiemService,
        private chuyenNganhTinhDiemService:ChuyenNganhTinhDiemService
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
                this.router.navigate(['/tap-chi'])
                return;
            }
        })
    }

    ngOnDestroy() {

    }

}