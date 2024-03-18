import {Component, Inject, OnDestroy, OnInit} from "@angular/core";
import {PagingService} from "../../../../core/services/paging.service";
import {LoadingService} from "../../../../core/services/loading.service";
import {BaiBaoService} from "../../../../core/services/baibao/bai-bao.service";
import {BaiBao} from "../../../../core/types/baibao/bai-bao.type";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {FormBuilder, FormGroup} from "@angular/forms";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ConstantsService} from "../../../../core/services/constants.service";
import {DeTaiService} from "../../../../core/services/detai/de-tai.service";
import {DeTai} from "../../../../core/types/detai/de-tai.type";

@Component({
    selector:'app-taikhoan-detai',
    templateUrl:'./de-tai.component.html',
    styleUrls:['./de-tai.component.css'],
})



export class DeTaiComponent implements OnInit,OnDestroy{

    deTaiKeKhai:DeTai[] = []
    deTaiThamGia:DeTai[] = []

    totalPageKeKhai: number
    totalPageThamGia: number

    isTableKeKhaiLoading:boolean = false
    isTableThamGiaLoading:boolean = false

    searchKeKhai$: Observable<[number, string, string]>
    searchThamGia$: Observable<[number, string, string]>

    destroy$ = new Subject<void>()

    formActionKeKhai: FormGroup
    formActionThamGia:FormGroup

    constructor(
        @Inject('paging1') private pagingService1: PagingService,
        @Inject('paging2') private pagingService2: PagingService,
        public loadingService:LoadingService,
        private deTaiService:DeTaiService,
        private notificationService:NzNotificationService,
        private fb:FormBuilder,
        public AppConstant:ConstantsService
    ) {

    }

    ngOnInit() {
        this.formActionKeKhai = this.fb.group({
            search:null,
            select:"created_at"
        })

        this.formActionThamGia = this.fb.group({
            search:null,
            select:"created_at"
        })

        this.getDeTaiKeKhai()
        this.getDeTaiThamGia()
    }

    getDeTaiKeKhai(){
        this.searchKeKhai$ = combineLatest([
            this.pagingService1.pageIndex$,
            this.pagingService1.keyword$,
            this.pagingService1.sortBy$,
        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.searchKeKhai$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isTableKeKhaiLoading = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex, keyword, sortBy]) => {
                return this.deTaiService.getDeTaiKeKhai(pageIndex, keyword, sortBy)
            })
        ).subscribe({
            next: (response) => {
                this.totalPageKeKhai = response.data.totalPage
                this.deTaiKeKhai = response.data.data
                this.isTableKeKhaiLoading = false
            },
            error: (error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isTableKeKhaiLoading = false
            }
        })
    }

    getDeTaiThamGia(){
        this.searchThamGia$ = combineLatest([
            this.pagingService2.pageIndex$,
            this.pagingService2.keyword$,
            this.pagingService2.sortBy$,
        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.searchThamGia$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isTableThamGiaLoading = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex, keyword, sortBy]) => {
                return this.deTaiService.getDeTaiKeKhai(pageIndex, keyword, sortBy)
            })
        ).subscribe({
            next: (response) => {
                this.totalPageThamGia = response.data.totalPage
                this.deTaiThamGia = response.data.data
                this.isTableThamGiaLoading = false
            },
            error: (error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isTableThamGiaLoading = false
            }
        })
    }


    onChangePageKeKhai(event:any){
        this.pagingService1.updatePageIndex(event)
    }

    onChangeSearchKeKhai(event:any){
        this.pagingService1.updateKeyword(event.target.value)
    }

    onChangeSortByKeKhai(event:any){
        this.pagingService1.updateSortBy(event)
    }

    onChangePageThamGia(event:any){
        this.pagingService2.updatePageIndex(event)
    }

    onChangeSearchThamGia(event:any){
        this.pagingService2.updateKeyword(event.target.value)
    }

    onChangeSortByThamGia(event:any){
        this.pagingService2.updateSortBy(event)
    }

    ngOnDestroy() {

    }
}