import {Component, OnDestroy, OnInit} from "@angular/core";
import {Magazine, UpdateTrangThaiTapChi} from "../../../core/types/tapchi/tap-chi.type";
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
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {FormBuilder, FormGroup} from "@angular/forms";

@Component({
    selector:'app-magazine-waiting',
    templateUrl:'./waiting.component.html',
    styleUrls:['./waiting.component.css']
})

export class MagazineWaitingComponent implements OnInit,OnDestroy{
    magazines:Magazine[] = []
    totalPage: number
    totalRecord: number
    isTableLoading:boolean = false
    columnDelete:boolean = false

    searchIsLock$: Observable<[number, string, string]>

    destroy$ = new Subject<void>()
    formAction: FormGroup

    constructor(
        private pagingService:PagingService,
        private notificationService:NzNotificationService,
        private tapChiService:TapChiService,
        private fb:FormBuilder
    ) {
    }


    ngOnInit() {
        this.formAction = this.fb.group({
            search:null,
            select:"created_at"
        })
        this.getTapChiChoDuyetPaging()
    }


    getTapChiChoDuyetPaging(){
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
                return this.tapChiService.getTapChiChoDuyetPaging(pageIndex, keyword, sortBy)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.totalRecord = response.data.totalRecord
                this.magazines = response.data.data.map((item) => {
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

    onSoftDeleteMagazine(magazine:Magazine){
        magazine.isSoftDelete = true;
        this.tapChiService.softDeleteTapChi(magazine.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.magazines = this.magazines.filter((item) => item.id !== magazine.id)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                magazine.isSoftDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                magazine.isSoftDelete = false
            }
        })
    }

    onChangeStatusTapChi(magazine:Magazine){
        magazine.isChangeStatus = true;

        const data:UpdateTrangThaiTapChi = {
            trangthai: true
        }

        this.tapChiService.updateTrangThaiTapChi(magazine.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.magazines = this.magazines.filter((item) => item.id !== magazine.id)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                magazine.isChangeStatus = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                magazine.isChangeStatus = false
            }
        })
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