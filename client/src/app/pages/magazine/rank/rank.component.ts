import {Component, OnDestroy, OnInit} from "@angular/core";
import {
    MagazineRecognize,
    TinhDiemTapChi,
    UpdateKhongCongNhan,
    UpdateXepHang,
    XepHangTapChi
} from "../../../core/types/tap-chi.type";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {NzModalService} from "ng-zorro-antd/modal";
import {TapChiService} from "../../../core/services/tap-chi.service";
import {LoadingService} from "../../../core/services/loading.service";
import {ActivatedRoute, Router} from "@angular/router";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {PagingService} from "../../../core/services/paging.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";

@Component({
    selector:'app-magazine-rank',
    templateUrl:'./rank.component.html',
    styleUrls:['./rank.component.css']
})

export class RankComponent implements OnInit,OnDestroy{
    id:number
    totalPage:number

    isUpdateLoading:boolean = false

    xepHangTapChi: XepHangTapChi[] = []

    formXepHang: FormGroup
    isOpenRecognizeForm:boolean = false

    destroy$ = new Subject<void>()

    paging$: Observable<[number]>

    constructor(
        private modal: NzModalService,
        private fb:FormBuilder,
        private tapChiService:TapChiService,
        public loadingService:LoadingService,
        private _router: ActivatedRoute,
        private router:Router,
        private notificationService:NzNotificationService,
        public pagingService:PagingService
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

        this.formXepHang = this.fb.group({
            khongduoccongnhan:[
                true,
                Validators.compose([
                    Validators.required
                ])
            ],
            ghichu:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })
        this.getLichSuTapChiKhongCongNhan()
    }

    onChangePage(event:any){
        this.pagingService.updatePageIndex(event)
    }

    updateLichSuTapChi(){
        const form = this.formXepHang
        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng nhập đầy đủ dữ liệu'
            )
            return
        }
        this.isUpdateLoading = true
        const data:UpdateXepHang = this.formXepHang.value
        this.tapChiService.updateXepHang(this.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.xepHangTapChi = [response.data,...this.xepHangTapChi]
                this.notificationService.create(
                    'success',
                    'Thành công',
                    response.message
                )
                this.isUpdateLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isUpdateLoading = false
            }
        })
    }

    getLichSuTapChiKhongCongNhan(){
        this.paging$ = combineLatest([
            this.pagingService.pageIndex$,
        ]).pipe(
            takeUntil(this.destroy$)
        )
        this.paging$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.loadingService.startLoading()),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex]) => {
                return this.tapChiService.getXepHangTapChi(this.id,pageIndex)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.xepHangTapChi = response.data.data
                this.loadingService.stopLoading()
            },
            error: (error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.loadingService.stopLoading()
                this.router.navigate(["/tap-chi"])
                return
            }
        })
    }

    openRecognizeForm(){
        this.isOpenRecognizeForm = !this.isOpenRecognizeForm
    }


    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }
}