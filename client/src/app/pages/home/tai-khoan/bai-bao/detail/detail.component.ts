import {Component} from "@angular/core";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {ChiTietBaiBao} from "../../../../../core/types/baibao/bai-bao.type";
import {User} from "../../../../../core/types/user/user.type";
import {CapNhatVaiTroTacGia, SanPhamTacGia, VaiTroTacGia} from "../../../../../core/types/sanpham/vai-tro-tac-gia.type";
import {LoadingService} from "../../../../../core/services/loading.service";
import {BaiBaoService} from "../../../../../core/services/baibao/bai-bao.service";
import {UserService} from "../../../../../core/services/user/user.service";
import {PagingService} from "../../../../../core/services/paging.service";
import {VaiTroService} from "../../../../../core/services/sanpham/vai-tro.service";
import {ConstantsService} from "../../../../../core/services/constants.service";
import {noWhiteSpaceValidator} from "../../../../../shared/validators/no-white-space.validator";
import {CapNhatFileMinhChung} from "../../../../../core/types/sanpham/file-minh-chung.type";

@Component({
    selector:"app-taikhoan-baibao-chitiet",
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class ChiTietBaiBaoComponent{
    id:number

    formCapNhatFileMinhChung:FormGroup
    formCapNhatTacGia:FormGroup

    isCapNhatFileMinhChung:boolean = false
    isOpenFormMinhChung:boolean = false
    isCapNhatTacGia:boolean = false
    isOpenFormTacGia:boolean = false
    isGetUsers:boolean = false
    isGetVaiTro:boolean =false

    search$:Observable<[string]>

    private firstSearch:boolean = false


    baibao:ChiTietBaiBao
    users:User[]
    vaiTros:VaiTroTacGia[]

    destroy$ = new Subject<void>()
    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private baiBaoService:BaiBaoService,
        private notificationService:NzNotificationService,
        private _router: ActivatedRoute,
        private router:Router,
        private userService:UserService,
        private pagingService:PagingService,
        private vaiTroService:VaiTroService,
        public AppConstant:ConstantsService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/home/tai-khoan/san-pham/bai-bao"])
                return;
            }
        })

        this.formCapNhatTacGia = this.fb.group({
            sanpham_tacgia:this.fb.array([]),
            users:[
                null
            ]
        })

        this.formCapNhatFileMinhChung = this.fb.group({
            url:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            loaiminhchung:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })


        this.getChiTietBaiBao()
    }

    onSelectUser(event:any){
        if(!event){
            return;
        }
        else{
            const data:User = event;
            const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
            const control = this.fb.group({
                id_tacgia:[data.id],
                tentacgia:[
                    data.name,
                    Validators.compose([
                        Validators.required,
                        noWhiteSpaceValidator
                    ])
                ],
                thutu:[null],
                tyledonggop:[null],
                id_vaitro:[null]
            })
            formArray.push(control);
            this.formCapNhatTacGia.get("users")?.setValue(null)
        }
    }

    getAllUser(){
        this.isGetUsers = true
        this.search$ = combineLatest([
            this.pagingService.keyword$,
        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.search$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isGetUsers = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([ keyword]) => {
                return this.userService.getAllUsers( keyword)
            })
        ).subscribe({
            next:(response) => {
                this.users = response.data
                this.isGetUsers = false
            },
            error:(error) => {
                this.notificationService.create(
                    "error",
                    "Lỗi",
                    error
                )
                this.isGetUsers = false
            }
        })
    }

    removeUser(index:number){
        (this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray).removeAt(index);
    }

    get sanphamTacgiaControls() {
        return (this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray).controls;
    }

    onSearchUser(event:any){
        if(!this.firstSearch && event.length >= 3){
            this.getAllUser()
        }
        if(event && event.length >= 3){
            this.pagingService.updateKeyword(event)
            this.firstSearch = true
        }
        if(event.length <= 0){
            console.log("reset đi ?")
            this.formCapNhatTacGia.get("users")?.reset()
        }
    }

    addGuestControls(){
        const control = this.fb.group({
            id_tacgia:[null],
            tentacgia:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            thutu:[null],
            tyledonggop:[null],
            id_vaitro:[null]
        })
        const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
        formArray.push(control)

    }

    onOpenFormCapNhatMinhChung(){
        this.isOpenFormMinhChung = !this.isOpenFormMinhChung
    }

    onOpenFormTacGia(isOpen : boolean){
        if(isOpen){
            this.isOpenFormTacGia = isOpen
            this.getVaiTroTacGia()
            // cập nhật lại dữ liệu tác giả trong form nếu bị tắt đột ngột
            const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
            formArray.clear()
            this.initSanPhamTacGia(this.baibao.sanpham_tacgias)
        }else{
            this.isOpenFormTacGia = isOpen
        }
    }

    getChiTietBaiBao(){
        this.loadingService.startLoading()
        this.baiBaoService.getChiTietBaiBao(this.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao = response.data
                this.formCapNhatFileMinhChung.patchValue({
                    url: this.baibao.sanpham.minhchung?.url,
                    loaiminhchung:this.baibao.sanpham.minhchung?.loaiminhchung ?? null
                })

                this.initSanPhamTacGia(response.data.sanpham_tacgias)
                this.loadingService.stopLoading()
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.loadingService.stopLoading()
                this.router.navigate(['/home/tai-khoan/san-pham/bai-bao'])
                return;
            }
        })
    }



    onCapNhatFileMinhChung(){
        if(this.formCapNhatFileMinhChung.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng điền đúng yêu cầu của form'
            )
            return;
        }
       const data:CapNhatFileMinhChung = this.formCapNhatFileMinhChung.value;
       this.isCapNhatFileMinhChung = true;
       this.baiBaoService.capNhatFileMinhChung(this.id,data)
           .pipe(
               takeUntil(this.destroy$)
           ).subscribe({
           next:(response) => {
               this.notificationService.create(
                   'success',
                   'Thành Công',
                   response.message

               )
               if (this.baibao && this.baibao.sanpham && this.baibao.sanpham.minhchung) {
                   this.baibao.sanpham.minhchung.url = data.url;
                   this.baibao.sanpham.minhchung.loaiminhchung = data.loaiminhchung ?? undefined
               }
               this.isOpenFormMinhChung = false
               this.isCapNhatFileMinhChung = false
           },
           error:(error) =>{
               this.notificationService.create(
                   'error',
                   'Lỗi',
                   error
               )
               this.isCapNhatFileMinhChung = false
           }
       })

    }

    onCapNhatTacGia(){
        const form = this.formCapNhatTacGia
        const arrayForm = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
        if(arrayForm.length <=0){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui chọn tác giả'
            )
            return;
        }
        if(arrayForm.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng điền đúng yêu cầu của form'
            )
            return;
        }

        const data:CapNhatVaiTroTacGia = form.value
        this.isCapNhatTacGia = true
        this.baiBaoService.capNhatVaiTroTacGia(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                if (this.baibao && this.baibao.sanpham_tacgias) {
                    this.baibao.sanpham_tacgias = response.data
                }
                this.isOpenFormTacGia = false
                this.isCapNhatTacGia = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isCapNhatTacGia = false
            }
        })
    }

    getVaiTroTacGia(){
        this.isGetVaiTro = true
        this.vaiTroService.getVaiTroBaiBao().pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) =>{
                this.vaiTros = response.data
                this.isGetVaiTro = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isGetVaiTro = false
                this.isOpenFormTacGia = false
            }
        })
    }

    private initSanPhamTacGia(data:SanPhamTacGia[]){
        const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
        data.map((item:SanPhamTacGia) => {
            const control = this.fb.group({
                id_tacgia:[item.tacgia.id],
                tentacgia:[
                    item.tacgia.name,
                    Validators.compose([
                        Validators.required,
                        noWhiteSpaceValidator
                    ])
                ],
                thutu:[item.thutu ?? null],
                tyledonggop:[item.tyledonggop ?? null],
                id_vaitro:[item.vaitrotacgia.id]
            })
            formArray.push(control);
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
        this.pagingService.resetValues()
    }
}