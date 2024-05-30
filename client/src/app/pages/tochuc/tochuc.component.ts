import {Component, OnDestroy, OnInit} from "@angular/core";
import {DeTai} from "../../core/types/detai/de-tai.type";
import {ToChuc} from "../../core/types/user-info/to-chuc.type";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {FormBuilder, FormGroup} from "@angular/forms";
import {PagingService} from "../../core/services/paging.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {DeTaiService} from "../../core/services/detai/de-tai.service";
import {ConstantsService} from "../../core/services/constants.service";
import {ToChucService} from "../../core/services/user-info/to-chuc.service";

@Component({
    selector:'app-tochuc',
    templateUrl:'./tochuc.component.html',
    styleUrls:['./tochuc.component.css']
})

export class ToChucComponent implements OnInit,OnDestroy{
    totalPage: number
    totalRecord: number
    isTableLoading:boolean = false
    toChucs:ToChuc[] = []

    searchIsLock$: Observable<[number,string, string]>

    destroy$ = new Subject<void>()

    formAction: FormGroup

    constructor(
        private pagingService:PagingService,
        private notificationService:NzNotificationService,
        private toChucService:ToChucService,
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
         this.getToChuc()
    }

    getToChuc(){
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
                return this.toChucService.getToChucPaging(pageIndex,keyword, sortBy)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.totalRecord = response.data.totalRecord
                this.toChucs = response.data.data.map((item) => {
                    return {
                        ...item,
                        isDelete:false,
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

    onXoaToChuc(tochuc:ToChuc){
        tochuc.isDelete = true;
        this.toChucService.xoaToChuc(tochuc.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.toChucs = this.toChucs.filter((item) => item.id !== tochuc.id)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                tochuc.isDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                tochuc.isDelete = false
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