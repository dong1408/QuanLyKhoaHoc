import {Component, OnDestroy, OnInit} from "@angular/core";
import {MagazineRecognize, UpdateKhongCongNhan} from "../../../core/types/tapchi/tap-chi.type";
import {data} from "autoprefixer";
import {NzModalRef, NzModalService} from "ng-zorro-antd/modal";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {LoadingService} from "../../../core/services/loading.service";
import {ActivatedRoute, Router} from "@angular/router";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {PagingService} from "../../../core/services/paging.service";
import {NzNotificationService} from "ng-zorro-antd/notification";

@Component({
    selector:'app-magazine-recognize',
    templateUrl:'./recognize.component.html',
    styleUrls:['./recognize.component.css']
})

export class RecognizeComponent implements OnInit,OnDestroy{

    id:number
    totalPage:number

    isUpdateLoading:boolean = false

    recognizes: MagazineRecognize[] = []

    formRecognize: FormGroup
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

        this.formRecognize = this.fb.group({
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
        const form = this.formRecognize
        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng nhập đầy đủ dữ liệu'
            )
            return
        }
        this.isUpdateLoading = true
        const data:UpdateKhongCongNhan = this.formRecognize.value
        this.tapChiService.updateKhongCongNhan(this.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.recognizes = [response.data,...this.recognizes]
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
                return this.tapChiService.getTapChiKhongCongNhan(this.id,pageIndex)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.recognizes = response.data.data
                this.loadingService.stopLoading()
                console.log(response.data)
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