import {Component, OnDestroy, OnInit} from "@angular/core";
import {PagingService} from "../../core/services/paging.service";
import {UserService} from "../../core/services/user/user.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {
    BehaviorSubject,
    combineLatest,
    debounceTime,
    distinctUntilChanged, mergeMap,
    Observable, Observer,
    Subject,
    switchMap,
    takeUntil,
    tap
} from "rxjs";
import {ImportUser, UpdateRole, UserVm} from "../../core/types/user/user.type";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Role} from "../../core/types/roles/role.type";
import {RoleService} from "../../core/services/roles/role.service";
import {NzUploadFile} from "ng-zorro-antd/upload";
import {validateFileImport, validateFileUpload} from "../../shared/validators/file-upload.validator";
import {CapNhatFileMinhChung} from "../../core/types/sanpham/file-minh-chung.type";

@Component({
    selector:'app-user-component',
    templateUrl:'./user.component.html',
    styleUrls:['./user.component.css']
})

export class UserComponent implements OnInit,OnDestroy{
    isTableLoading:boolean = false
    isOpenFormUpdateRole: boolean = false
    isGetRoleOfCurrentuser:boolean = false
    isOpenFormImport:boolean = false
    isImport:boolean = false

    fileList:NzUploadFile[] = []

    currentUserId:number | null

    isUpdateRole: boolean = false

    users:UserVm[] = []
    roles:Role[] = []

    currentButton$ = new BehaviorSubject<number>(1)
    columnDelete:boolean = false

    destroy$ = new Subject<void>()
    formAction: FormGroup
    formUpdateRole:FormGroup
    formImport:FormGroup

    totalPage:number
    totalRecord:number

    searchIsLock$: Observable<[number, string, string,number]>

    constructor(
        private fb:FormBuilder,
        public pagingService:PagingService,
        private userService:UserService,
        private notificationService:NzNotificationService,
        private roleService:RoleService
    ) {

    }

    ngOnInit() {
        this.formAction = this.fb.group({
            search:null,
            select:"created_at",
            filter:"all"
        })

        this.formUpdateRole = this.fb.group({
            roles_id:[
                [[]],
                Validators.compose([
                    Validators.required
                ])
            ]
        })

        this.formImport = this.fb.group({
            file:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ]
        })

        this.getAllRoles()
        this.getAllUser()
    }

    onImport(){
        if(this.formImport.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng điền đúng yêu cầu của form'
            )
            return;
        }
        if(this.fileList.length <= 0){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng chọn file cần upload'
            )
            return;
        }

        const data:ImportUser = this.formImport.value;

        const formData = new FormData()
        formData.append("file",data.file)
        this.isImport = true;
        this.userService.importUsers(formData).pipe(
            takeUntil(this.destroy$),
        ).subscribe({
            next:(response) =>{

                const blob = new Blob([response], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'})


                var downloadURL = window.URL.createObjectURL(blob);
                var link = document.createElement('a');
                link.href = downloadURL;
                link.download = "result_import.xlsx";
                link.click();

                window.URL.revokeObjectURL(downloadURL)

                this.isOpenFormImport = false
                this.fileList = []
                this.formImport.reset()
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    'Import thành công'
                )
                this.pagingService.updatePageIndex(0    )
                this.isImport = false


            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Có lỗi trong quá trình import, vui lòng thử lại sau'
                )
                this.isImport = false
            }
        })
    }

    onOpenFormImport(){
        this.isOpenFormImport = !this.isOpenFormImport
    }

    onCloseFormUpdateRole(){
        this.currentUserId = null
        this.isOpenFormUpdateRole = false
    }
    onOpenFormUpdateRole(user:UserVm){
        this.isGetRoleOfCurrentuser = true
        this.currentUserId = user.id
        this.isOpenFormUpdateRole = true
        this.userService.getUserRole(user.id)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.formUpdateRole.patchValue({
                    roles_id: response.data.map(item => item.id)
                })

                this.isGetRoleOfCurrentuser = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isOpenFormUpdateRole = false
                this.isGetRoleOfCurrentuser = false
            }
        })
    }

    getAllRoles(){
        this.roleService.getAllRoles()
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.roles = response.data
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
            }
        })
    }

    onUpdateRole(){

        const form = this.formUpdateRole

        if(form.invalid){
            this.notificationService.create(
                'error',
                "Lỗi",
                "Vui lòng điền đúng yêu cầu của form"
            )

            Object.values(form.controls).forEach(control => {
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({onlySelf: true})
                }
            })

            return;
        }

        const data:UpdateRole = form.value

        this.isUpdateRole = true
        this.userService.updateRoleUser(this.currentUserId!!,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.users = this.users.map((item) => {
                    if(item.id === this.currentUserId){
                        return {
                            ...item,
                            roles: response.data,
                            roleString: response.data?.map(i => i.name).join(", ")
                        }
                    }
                    return item
                })

                this.onCloseFormUpdateRole()
                this.isUpdateRole = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isUpdateRole = false
            }
        })
    }

    getAllUser(){
        this.searchIsLock$ = combineLatest([
            this.pagingService.pageIndex$,
            this.pagingService.keyword$,
            this.pagingService.sortBy$,
            this.pagingService.isLock$,

        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.searchIsLock$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isTableLoading = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([pageIndex, keyword, sortBy,islock]) => {
                return this.userService.getUserPaging(keyword, pageIndex, islock,sortBy)
            })
        ).subscribe({
            next:(response) => {
                this.totalPage = response.data.totalPage
                this.totalRecord =response.data.totalRecord
                this.users = response.data.data.map(item => {
                    return {
                        ...item,
                        isSoftDelete:false,
                        isRestore:false,
                        isDelete:false,
                        roleString: item.roles?.map(i => i.name).join(", ")
                    }
                })
                this.isTableLoading = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isTableLoading = false
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

    onSoftDeleteUser(user:UserVm){
        user.isSoftDelete = true
        this.userService.softDeleteUser(user.id)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.users = this.users.filter(item => item.id !== user.id)
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )

                user.isSoftDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )

                user.isSoftDelete = false
            }
        })
    }

    onForceDeleteUe(user:UserVm){
        user.isDelete = true
        this.userService.forceDeleteUser(user.id)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.users = this.users.filter(item => item.id !== user.id)
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )

                user.isDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )

                user.isDelete = false
            }
        })
    }

    onRestoreUser(user:UserVm){
        user.isRestore = true
        this.userService.restoreUser(user.id)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.users = this.users.filter(item => item.id !== user.id)
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                user.isRestore = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )

                user.isRestore = false
            }
        })
    }

    beforeUpload = (file: NzUploadFile):Observable<boolean> =>
        new Observable((observer: Observer<boolean>) => {
            const errorMessage = validateFileImport(file,this.fileList)

            if (errorMessage) {
                this.notificationService.create('error', 'Lỗi', errorMessage);
                observer.complete();
                return;
            }

            observer.next(false);
            this.fileList = this.fileList.concat(file)
            this.formImport.patchValue({
                file: file
            })
            file.status = "success"
            observer.complete();
        })

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
        this.pagingService.resetValues()
    }
}