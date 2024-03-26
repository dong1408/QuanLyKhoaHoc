import {Component, OnDestroy, OnInit} from "@angular/core";
import {
    MagazineRecognize,
    TinhDiemTapChi,
    UpdateKhongCongNhan,
    UpdateXepHang,
    XepHangTapChi
} from "../../../core/types/tapchi/tap-chi.type";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {NzModalService} from "ng-zorro-antd/modal";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {LoadingService} from "../../../core/services/loading.service";
import {ActivatedRoute, Router} from "@angular/router";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {PagingService} from "../../../core/services/paging.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {PhanLoaiTapChiService} from "../../../core/services/tapchi/phan-loai-tap-chi.service";
import {PhanLoaiTapChi} from "../../../core/types/tapchi/phan-loai-tap-chi.type";
import {validValuesValidator} from "../../../shared/validators/valid-value.validator";

@Component({
    selector:'app-magazine-rank',
    templateUrl:'./rank.component.html',
    styleUrls:['./rank.component.css']
})

export class RankComponent implements OnInit,OnDestroy{
    id:number
    totalPage:number

    isOpenForm:boolean = false
    isUpdateLoading:boolean = false
    isPhanLoaiTapChiLoading:boolean = false

    xepHangTapChi: XepHangTapChi[] = []
    phanLoaiTapChi:PhanLoaiTapChi[] = []

    formXepHang: FormGroup

    destroy$ = new Subject<void>()

    paging$: Observable<[number]>

    selected:Array<string> = []

    constructor(
        private fb:FormBuilder,
        private tapChiService:TapChiService,
        public loadingService:LoadingService,
        private _router: ActivatedRoute,
        private router:Router,
        private notificationService:NzNotificationService,
        public pagingService:PagingService,
        private phanLoaiTapChiService:PhanLoaiTapChiService
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

        this.formXepHang = this.fb.group({
            id_phanloaitapchi:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            if:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            wos:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(["SCIE","SSCI","A&HCI","ESCI"])
                ])
            ],
            quartile:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(["q1","q2","q3","q4"])
                ])
            ],
            abs:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(["1","2","3","4"])
                ])
            ],
            abcd:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(["A*","A","B","C"])
                ])
            ],
            aci:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(["0","1"])
                ])
            ],
            ghichu:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
        })
        this.getXepHangTapChi()
    }

    onChangePage(event:any){
        this.pagingService.updatePageIndex(event)
    }


    getXepHangTapChi(){
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
                this.router.navigate(["/admin/tap-chi"])
                return
            }
        })
    }



    getPhanLoaiTapChi(){
        this.isPhanLoaiTapChiLoading = true
        this.phanLoaiTapChiService.getPhanLoaiTapChi()
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.phanLoaiTapChi = response.data
                this.isPhanLoaiTapChiLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isPhanLoaiTapChiLoading = false
            }
        })
    }


    onXepHangTapChi(){
        const form = this.formXepHang
        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng nhập đầy đủ dữ liệu'
            )

            Object.values(form.controls).forEach(control =>{
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({ onlySelf: true });
                }
            })

            return
        }

        const values = this.formXepHang.controls['id_phanloaitapchi'].value
        const idArr = values.map((item:any) => item.id)
        const data:UpdateXepHang = {
            if :this.formXepHang.controls['if'].value,
            wos: this.selected.includes('wos') ? this.formXepHang.controls['wos'].value : null,
            aci:this.selected.includes('aci') ? this.formXepHang.controls['aci'].value : null,
            abs:this.selected.includes('abs') ? this.formXepHang.controls['abs'].value : null,
            abcd:this.selected.includes('abcd') ? this.formXepHang.controls['abcd'].value : null,
            quartile:this.selected.includes('quartile') ? this.formXepHang.controls['quartile'].value : null,
            ghichu:this.formXepHang.controls['ghichu'].value,
            dmphanloaitapchi:idArr
        }
        this.isUpdateLoading = true
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
                this.formXepHang.reset()
                this.isOpenForm = false
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

    openRecognizeForm(){
        this.getPhanLoaiTapChi()
        this.isOpenForm = !this.isOpenForm
    }


    onSelectChange(event:any){
        const mas = event.map((item:any) => item.ma)
        this.selected = []
        this.selected = mas
    }

    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }
}