import {Component} from "@angular/core";
import {BaiBao} from "../../core/types/baibao/bai-bao.type";
import {
    BehaviorSubject,
    combineLatest,
    debounceTime,
    distinctUntilChanged,
    Observable,
    Subject, switchMap,
    takeUntil,
    tap
} from "rxjs";
import {FormBuilder, FormGroup} from "@angular/forms";
import {PagingService} from "../../core/services/paging.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {BaiBaoService} from "../../core/services/baibao/bai-bao.service";
import {ConstantsService} from "../../core/services/constants.service";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../core/types/sanpham/san-pham.type";
import {DeTai} from "../../core/types/detai/de-tai.type";
import {DeTaiService} from "../../core/services/detai/de-tai.service";

@Component({
    selector:'app-detai',
    templateUrl:'./detai.component.html',
    styleUrls:['./detai.component.css']
})

export class DeTaiComponent{
    deTais:DeTai[] = []
    currentButton$ = new BehaviorSubject<number>(1)
    totalPage: number
    totalRecord: number
    isTableLoading:boolean = false
    columnDelete:boolean = false

    searchIsLock$: Observable<[number, string, string,number,string]>

    destroy$ = new Subject<void>()

    formAction: FormGroup

    constructor(
        private pagingService:PagingService,
        private notificationService:NzNotificationService,
        private deTaiService:DeTaiService,
        private fb:FormBuilder,
        public AppConstant:ConstantsService
    ) {
    }


    ngOnInit() {
        this.formAction = this.fb.group({
            search:null,
            select:"created_at",
            filter:"all"
        })
        this.getBaiBao()
    }


    getBaiBao(){
        this.searchIsLock$ = combineLatest([
            this.pagingService.pageIndex$,
            this.pagingService.keyword$,
            this.pagingService.sortBy$,
            this.pagingService.isLock$,
            this.pagingService.filter$

        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.searchIsLock$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isTableLoading = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex, keyword, sortBy,islock,filter]) => {
                return this.deTaiService.getDeTais(keyword, pageIndex, sortBy,islock,filter)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.totalRecord = response.data.totalRecord
                this.deTais = response.data.data.map((item) => {
                    return {
                        ...item,
                        isSoftDelete:false,
                        isDelete:false,
                        isReStore:false,
                        isChangeStatus:false
                    }
                })
                this.isTableLoading = false
            },
            error: (error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isTableLoading = false
            }
        })
    }

    onXoaMemDeTai(deTai:DeTai){
        deTai.isSoftDelete = true;
        this.deTaiService.xoaMemDeTai(deTai.id_sanpham).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.deTais = this.deTais.filter((item) => item.id_sanpham !== deTai.id_sanpham)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                deTai.isSoftDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                deTai.isSoftDelete = false
            }
        })
    }

    onXoaDeTai(deTai:DeTai){
        deTai.isDelete = true;
        this.deTaiService.xoaDeTai(deTai.id_sanpham).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.deTais = this.deTais.filter((item) => item.id_sanpham !== deTai.id_sanpham)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                deTai.isDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                deTai.isDelete = false
            }
        })
    }

    onCapNhatTrangThai(deTai:DeTai,trangthai:TrangThaiSanPham){
        deTai.isChangeStatus = true;

        const data:CapNhatTrangThaiSanPham = {
            trangthairasoat: trangthai
        }

        this.deTaiService.capNhatTrangThaiSanPham(deTai.id_sanpham,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.deTais = this.deTais.filter((item) => item.id_sanpham !== deTai.id_sanpham)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                deTai.isChangeStatus = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                deTai.isChangeStatus = false
            }
        })
    }

    onHoanTacXoaDeTai(deTai:DeTai){
        deTai.isReStore = true;
        this.deTaiService.hoanTacXoaDeTai(deTai.id_sanpham).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.deTais = this.deTais.filter((item) => item.id_sanpham !== deTai.id_sanpham)
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                deTai.isReStore = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                deTai.isReStore = false
            }
        })
    }

    setCurrentButton(number:number){
        if(number === 1){
            this.onChangeIsLock(0)
            this.columnDelete = false
        }
        if(number == 2){
            this.onChangeIsLock(1)
            this.columnDelete = true
        }
        this.currentButton$.next(number)
    }

    onChangeIsLock(value:number){
        this.pagingService.updateIsLock(value)
    }

    onChangePage(event:any){
        this.pagingService.updatePageIndex(event)
    }

    onChangeSearch(event:any){
        this.pagingService.updateKeyword(event.target.value)
    }

    onChangeSortBy(event:any){
        this.pagingService.updateSortBy(event)
    }

    onChangeFilter(event:any){
        this.pagingService.updateFilter(event)
    }

    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }
}