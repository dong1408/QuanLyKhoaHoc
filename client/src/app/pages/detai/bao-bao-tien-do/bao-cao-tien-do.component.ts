import {Component} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {LoadingService} from "../../../core/services/loading.service";
import {ActivatedRoute, Router} from "@angular/router";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {PagingService} from "../../../core/services/paging.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";
import {BaoCaoTienDo, BaoCaoTienDoDeTai} from "../../../core/types/detai/de-tai.type";
import {dateConvert} from "../../../shared/commons/utilities";

@Component({
    selector:'app-detai-baocao',
    templateUrl:'./bao-cao-tien-do.component.html',
    styleUrls:['./bao-cao-tien-do.component.css']
})

export class BaoCaoTienDoComponent{
    id:number
    totalPage:number

    baocaos:BaoCaoTienDo[] = []

    isOpenForm:boolean = false
    isUpdateLoading:boolean = false

    formBaoCao: FormGroup

    destroy$ = new Subject<void>()

    paging$: Observable<[number]>


    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private _router: ActivatedRoute,
        private router:Router,
        private notificationService:NzNotificationService,
        public pagingService:PagingService,
        private deTaiService:DeTaiService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/de-tai"])
                return;
            }
        })

        this.formBaoCao = this.fb.group({
            tenbaocao:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.required
                ])
            ],
            ngaynopbaocao:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            ketquaxet:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            thoigiangiahan:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
        })
        this.getLichSuBaoCaoDeTai()
    }

    onChangePage(event:any){
        this.pagingService.updatePageIndex(event)
    }


    getLichSuBaoCaoDeTai(){
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
                return this.deTaiService.getLichSuBaoCaoDeTai(this.id,pageIndex)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.baocaos = response.data.data
                this.loadingService.stopLoading()
            },
            error: (error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.loadingService.stopLoading()
                this.router.navigate(["/admin/de-tai"])
                return
            }
        })
    }


    onOpenFormBaoCao(){
        this.isOpenForm = !this.isOpenForm
    }


    onBaoCaoTienDoDeTai(){
        const form = this.formBaoCao
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

        const data:BaoCaoTienDoDeTai = {
            ...form.value,
            ngaynopbaocao: dateConvert(form.get("ngaynopbaocao")?.value.toString())
        }

        this.isUpdateLoading = true
        this.deTaiService.baoCaoTienDoDeTai(this.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baocaos = [response.data,...this.baocaos]
                this.notificationService.create(
                    'success',
                    'Thành công',
                    response.message
                )
                this.isUpdateLoading = false
                this.formBaoCao.reset()
                this.isOpenForm = false
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

    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }
}