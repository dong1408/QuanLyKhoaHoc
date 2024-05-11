import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzModalService} from "ng-zorro-antd/modal";
import {MagazineRecognize, TinhDiemTapChi, UpdateTinhDiem} from "../../../core/types/tapchi/tap-chi.type";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {LoadingService} from "../../../core/services/loading.service";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {PagingService} from "../../../core/services/paging.service";
import {NganhTinhDiem} from "../../../core/types/quydoi/nganh-tinh-diem.type";
import {ChuyenNganhTinhDiem} from "../../../core/types/quydoi/chuyen-nganh-tinh-diem.type";
import {ActivatedRoute, Router} from "@angular/router";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {NganhTinhDiemService} from "../../../core/services/quydoi/nganh-tinh-diem.service";
import {ChuyenNganhTinhDiemService} from "../../../core/services/quydoi/chuyen-nganh-tinh-diem.service";

@Component({
    selector:'app-magazine-score',
    templateUrl:'./score.component.html',
    styleUrls:['./score.component.css']
})

export class ScoreComponent implements OnInit,OnDestroy{
    id:number
    totalPage:number

    formTinhDiem: FormGroup
    isOpenForm:boolean = false

    nganhTinhDiems:NganhTinhDiem[] = []
    chuyenNganhTinhDiems:ChuyenNganhTinhDiem[] = []

    tinhDiemTapChis:TinhDiemTapChi[] = []

    destroy$ = new Subject<void>()
    paging$: Observable<[number]>

    isNganhTinhDiemLoading:boolean = false
    isChuyenNganhTinhDiemLoading:boolean = false
    isCapNhatTinhDiem:boolean = false

    constructor(
        private modal: NzModalService,
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private tapChiService:TapChiService,
        private notificationService:NzNotificationService,
        private _router: ActivatedRoute,
        private router:Router,
        private nganhTinhDiemService:NganhTinhDiemService,
        private chuyenNganhTinhDiemService:ChuyenNganhTinhDiemService,
        public pagingService:PagingService
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

        this.formTinhDiem = this.fb.group({
            id_nganhtinhdiem:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            id_chuyennganhtinhdiem:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            diem:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            namtinhdiem:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            ghichu:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })
        this.getLichSuTinhDiem()
    }

    getLichSuTinhDiem(){
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
                return this.tapChiService.getTapChiTinhDiem(this.id,pageIndex)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.tinhDiemTapChis = response.data.data
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

    getNganhTinhDiem(){
        this.isNganhTinhDiemLoading = true
        this.nganhTinhDiemService.getNganhTinhDiem()
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.nganhTinhDiems = response.data
                this.isNganhTinhDiemLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isNganhTinhDiemLoading = false
            }
        })
    }

    getChuyenNganhTinhDiem(idNganhTinhDiem:number){
        this.isChuyenNganhTinhDiemLoading = true
        this.chuyenNganhTinhDiemService.getChuyenNganhTinhDiemByIdNganhTinhDiem(idNganhTinhDiem)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.chuyenNganhTinhDiems = response.data
                this.isChuyenNganhTinhDiemLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isChuyenNganhTinhDiemLoading = false
            }
        })
    }

    openRecognizeForm(){
        this.isOpenForm = !this.isOpenForm
        this.getNganhTinhDiem()
    }

    tinhDiemTapChi(){
        const form = this.formTinhDiem
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

        const data:UpdateTinhDiem = form.value
        this.isCapNhatTinhDiem = true
        this.tapChiService.updateTinhDiem(this.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.tinhDiemTapChis = [response.data,...this.tinhDiemTapChis]
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.formTinhDiem.reset()
                this.isOpenForm = false
                this.isCapNhatTinhDiem = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isCapNhatTinhDiem = false
            }
        })
    }

    onChangePage(event:any){
        this.pagingService.updatePageIndex(event)
    }

    onSelectChange(event:any){
        if(typeof(event) === 'number'){
            this.formTinhDiem.controls?.['id_chuyennganhtinhdiem'].setValue(null)
            this.getChuyenNganhTinhDiem(event)
        }else{
            this.chuyenNganhTinhDiems = []
        }
        if(!this.formTinhDiem.controls?.['id_nganhtinhdiem'].value){
            this.chuyenNganhTinhDiems = []
        }
    }

    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }
}