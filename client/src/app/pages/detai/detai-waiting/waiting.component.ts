import {Component, OnDestroy, OnInit} from "@angular/core";
import {
    combineLatest,
    debounceTime,
    distinctUntilChanged,
    map,
    Observable,
    Subject,
    switchMap,
    takeUntil,
    tap
} from "rxjs";
import {PagingService} from "../../../core/services/paging.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {FormBuilder, FormGroup} from "@angular/forms";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../../core/types/sanpham/san-pham.type";
import {ConstantsService} from "../../../core/services/constants.service";
import {DeTai} from "../../../core/types/detai/de-tai.type";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";

@Component({
    selector:'app-baibao-waiting',
    templateUrl:'./waiting.component.html',
    styleUrls:['./waiting.component.css']
})

export class DeTaiWaitingComponent implements OnInit,OnDestroy{
    deTais:DeTai[] = []
    totalPage: number
    isTableLoading:boolean = false
    columnDelete:boolean = false

    searchIsLock$: Observable<[number, string, string]>

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
            select:"created_at"
        })
        this.getBaiBaoChoDuyet()
    }


    getBaiBaoChoDuyet(){
        this.searchIsLock$ = combineLatest([
            this.pagingService.pageIndex$,
            this.pagingService.keyword$,
            this.pagingService.sortBy$,
        ]).pipe(
           takeUntil(this.destroy$)
        )

        this.searchIsLock$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isTableLoading = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex, keyword, sortBy]) => {
                return this.deTaiService.getDeTaiChoDuyet(pageIndex, keyword, sortBy)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                console.log(response.data)
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


    onChangePage(event:any){
        this.pagingService.updatePageIndex(event)
    }

    onChangeSearch(event:any){
        this.pagingService.updateKeyword(event.target.value)
    }

    onChangeSortBy(event:any){
        this.pagingService.updateSortBy(event)
    }

    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }
}