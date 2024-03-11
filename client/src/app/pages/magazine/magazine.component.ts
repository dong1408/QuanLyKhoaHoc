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
import {PagingServiceFactory} from "../../core/services/paging-service.factory";
import {FormBuilder, FormGroup} from "@angular/forms";

@Component({
    selector:'app-magazine',
    templateUrl:'./magazine.component.html',
    styleUrls:['./magazine.component.css']
})

export class MagazineComponent implements OnInit,OnDestroy{
    magazines:Magazine[] = []
    currentButton$ = new BehaviorSubject<number>(1)
    totalPage: number
    isTableLoading:boolean = false
    columnDelete:boolean = false

    searchIsLock$: Observable<[number, string, string,number]>

    destroy$ = new Subject<void>()

    formAction: FormGroup

    selectValue: Array<{label:string,value:string}>

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
        this.getTapChiPaging()
    }


    getTapChiPaging(){
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
                return this.tapChiService.getTapChiPaging(pageIndex, keyword, sortBy,islock)
            })
        ).subscribe({
            next: (response) => {
                this.totalPage = response.data.totalPage
                this.magazines = response.data.data.map((item) => {
                    return {
                        ...item,
                        isSoftDelete:false,
                        isDelete:false,
                        isReStore:false,
                        isChangeStatus:false
                    }
                })
                console.log(response.data.data)
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

    onForceDeleteMagazine(magazine:Magazine){
        magazine.isDelete = true;
        this.tapChiService.forceDeleteTapChi(magazine.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.magazines = this.magazines.filter((item) => item.id !== magazine.id)

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                magazine.isDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                magazine.isDelete = false
            }
        })
    }

    onChangeStatusTapChi(magazine:Magazine){
        magazine.isChangeStatus = true;

        const data:UpdateTrangThaiTapChi = {
            trangthai: false
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

     onRestoreMagazine(magazine:Magazine){
         magazine.isReStore = true;
         this.tapChiService.restoreTapChi(magazine.id).pipe(
             takeUntil(this.destroy$)
         ).subscribe({
             next:(response) => {
                 this.magazines = this.magazines.filter((item) => item.id !== magazine.id)
                 this.notificationService.create(
                     'success',
                     'Thành Công',
                     response.message
                 )
                 magazine.isReStore = false
             },
             error:(error) => {
                 this.notificationService.create(
                     'error',
                     'Lỗi',
                     error
                 )
                 magazine.isReStore = false
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
        console.log("magaazine run")
        this.destroy$.next();
        this.destroy$.complete();
        this.pagingService.resetValues()
    }

}