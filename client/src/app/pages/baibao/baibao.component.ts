import {Component, OnDestroy, OnInit} from "@angular/core";
import {Magazine, UpdateTrangThaiTapChi} from "../../core/types/tapchi/tap-chi.type";
import {PagingService} from "../../core/services/paging.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {
    BehaviorSubject,
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
import {TapChiService} from "../../core/services/tapchi/tap-chi.service";
import {FormBuilder, FormGroup} from "@angular/forms";
import {BaiBao} from "../../core/types/baibao/bai-bao.type";
import {BaiBaoService} from "../../core/services/baibao/bai-bao.service";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../core/types/sanpham/san-pham.type";
import {ConstantsService} from "../../core/services/constants.service";

@Component({
    selector:'app-baibao',
    templateUrl:'./baibao.component.html',
    styleUrls:['./baibao.component.css']
})

export class BaiBaoComponent implements OnInit,OnDestroy{
    baiBaos:BaiBao[] = []
    currentButton$ = new BehaviorSubject<number>(1)
    totalPage: number
    totalRecord:number
    isTableLoading:boolean = false
    columnDelete:boolean = false

    searchIsLock$: Observable<[number, string, string,number]>

    destroy$ = new Subject<void>()

    formAction: FormGroup

    constructor(
        private pagingService:PagingService,
        private notificationService:NzNotificationService,
        private baiBaoService:BaiBaoService,
        private fb:FormBuilder,
        public AppConstant:ConstantsService
    ) {
    }


    ngOnInit() {
        this.formAction = this.fb.group({
            search:null,
            select:"created_at"
        })
        this.getBaiBao()
    }


    getBaiBao(){
        this.searchIsLock$ = combineLatest([
            this.pagingService.pageIndex$,
            this.pagingService.keyword$,
            this.pagingService.sortBy$,
            this.pagingService.isLock$
        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.searchIsLock$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isTableLoading = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex, keyword, sortBy,islock]) => {
                return this.baiBaoService.getBaiBao(pageIndex, keyword, sortBy,islock)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.totalRecord = response.data.totalRecord
                this.baiBaos = response.data.data.map((item) => {
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

     onXoaMemBaiBao(baiBao:BaiBao){
         baiBao.isSoftDelete = true;
        this.baiBaoService.xoaMemBaiBao(baiBao.id_sanpham).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baiBaos = this.baiBaos.filter((item) => item.id_sanpham !== baiBao.id_sanpham)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                baiBao.isSoftDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                baiBao.isSoftDelete = false
            }
        })
     }

    onXoaBaiBao(baiBao:BaiBao){
        baiBao.isDelete = true;
        this.baiBaoService.xoaBaiBao(baiBao.id_sanpham).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baiBaos = this.baiBaos.filter((item) => item.id_sanpham !== baiBao.id_sanpham)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                baiBao.isDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                baiBao.isDelete = false
            }
        })
    }

    onCapNhatTrangThai(baiBao:BaiBao,trangthai:TrangThaiSanPham){
            baiBao.isChangeStatus = true;

            const data:CapNhatTrangThaiSanPham = {
                trangthairasoat: trangthai
            }

            this.baiBaoService.capNhatTrangThaiSanPham(baiBao.id_sanpham,data).pipe(
                takeUntil(this.destroy$)
            ).subscribe({
                next:(response) => {
                    this.baiBaos = this.baiBaos.filter((item) => item.id_sanpham !== baiBao.id_sanpham)

                    this.notificationService.create(
                        'success',
                        'Thành Công',
                        response.message
                    )
                    baiBao.isChangeStatus = false
                },
                error:(error) => {
                    this.notificationService.create(
                        'error',
                        'Lỗi',
                        error
                    )
                    baiBao.isChangeStatus = false
                }
            })
    }

     onHoanTacXoaBaiBao(baiBao:BaiBao){
         baiBao.isReStore = true;
         this.baiBaoService.hoanTacXoaBaiBao(baiBao.id_sanpham).pipe(
             takeUntil(this.destroy$)
         ).subscribe({
             next:(response) => {
                 this.baiBaos = this.baiBaos.filter((item) => item.id_sanpham !== baiBao.id_sanpham)
                 this.notificationService.create(
                     'success',
                     'Thành Công',
                     response.message
                 )
                 baiBao.isReStore = false
             },
             error:(error) => {
                 this.notificationService.create(
                     'error',
                     'Lỗi',
                     error
                 )
                 baiBao.isReStore = false
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

    ngOnDestroy() {
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }

}