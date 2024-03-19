import {Component} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {combineLatest, debounceTime, distinctUntilChanged, Observable, Subject, switchMap, takeUntil, tap} from "rxjs";
import {User} from "../../../core/types/user/user.type";
import {CapNhatVaiTroTacGia, SanPhamTacGia, VaiTroTacGia} from "../../../core/types/sanpham/vai-tro-tac-gia.type";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {UserService} from "../../../core/services/user/user.service";
import {PagingService} from "../../../core/services/paging.service";
import {VaiTroService} from "../../../core/services/sanpham/vai-tro.service";
import {ConstantsService} from "../../../core/services/constants.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {CapNhatFileMinhChung} from "../../../core/types/sanpham/file-minh-chung.type";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../../core/types/sanpham/san-pham.type";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";
import {ChiTietDeTai, NghiemThuDeTai, TuyenChonDeTai, XetDuyetDeTai} from "../../../core/types/detai/de-tai.type";
import {dateConvert} from "../../../shared/commons/utilities";

@Component({
    selector:'app-detai-chitiet',
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class ChiTietDeTaiComponent{
    id:number

    formCapNhatFileMinhChung:FormGroup
    formCapNhatTacGia:FormGroup
    formXetDuyet:FormGroup
    formNghiemThu:FormGroup
    formTuyenChon:FormGroup

    isOpenFormTuyenChon:boolean = false
    isTuyenChon:boolean = false
    isOpenFormXetDuyet:boolean = false
    isXetDuyet:boolean = false
    isOpenFormNghiemThu:boolean = false
    isNghiemThu:boolean = false

    isCapNhatFileMinhChung:boolean = false
    isOpenFormMinhChung:boolean = false
    isCapNhatTacGia:boolean = false
    isOpenFormTacGia:boolean = false
    isGetUsers:boolean = false
    isGetVaiTro:boolean =false

    search$:Observable<[string]>

    private firstSearch:boolean = false

    isRestore:boolean = false
    isForceDelete:boolean = false
    isSoftDelete:boolean = false
    isChangeStatus:boolean = false
    isDelete:boolean = false

    detai:ChiTietDeTai
    users:User[]
    vaiTros:VaiTroTacGia[]

    destroy$ = new Subject<void>()
    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private deTaiService:DeTaiService,
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
                this.router.navigate(["/admin/de-tai"])
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

        this.formTuyenChon = this.fb.group({
            ketquatuyenchon:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            lydo:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })

        this.formXetDuyet = this.fb.group({
            ngayxetduyet:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            ketquaxetduyet:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            sohopdong:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            ngaykyhopdong:[
                null,
            ],
            thoihanhopdong:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            kinhphi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })

        this.formNghiemThu = this.fb.group({
            hoidongnghiemthu:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            ngaynghiemthu:[
                null
            ],
            ketquanghiemthu:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            ngaycongnhanhoanthanh:[
                null
            ],
            soqdcongnhanhoanthanh:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            thoigiangiahan:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })

        this.getChiTietDeTai()
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

    onOpenFormTuyenChon(){
        this.isOpenFormTuyenChon = !this.isOpenFormTuyenChon
    }

    onOpenFormXetDuyet(){
        this.isOpenFormXetDuyet = !this.isOpenFormXetDuyet
    }

    onOpenFormNghiemThu(){
        this.isOpenFormNghiemThu = !this.isOpenFormNghiemThu
    }

    onOpenFormTacGia(isOpen : boolean){
        if(isOpen){
            this.isOpenFormTacGia = isOpen
            this.getVaiTroTacGia()
            const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
            formArray.clear()
            this.initSanPhamTacGia(this.detai.sanpham_tacgias)
        }else{
            this.isOpenFormTacGia = isOpen
        }
    }

    getChiTietDeTai(){
        this.loadingService.startLoading()
        this.deTaiService.getChiTietDeTai(this.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.detai = response.data
                this.formCapNhatFileMinhChung.patchValue({
                    url: this.detai.sanpham.minhchung?.url,
                    loaiminhchung:this.detai.sanpham.minhchung?.loaiminhchung ?? null
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
                this.router.navigate(['/admin/de-tai'])
                return;
            }
        })
    }

    onXoaMemDeTai(deTai:ChiTietDeTai){
        this.isSoftDelete = true;
        this.deTaiService.xoaMemDeTai(deTai.sanpham.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                deTai.deleted_at = Date.now().toString()
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isSoftDelete = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isSoftDelete = false
            }
        })
    }

    onXoaDeTai(deTai:ChiTietDeTai){
        this.isDelete = true;
        this.deTaiService.xoaDeTai(deTai.sanpham.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isDelete = false
                this.router.navigate(['/admin/de-tai'])
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isDelete = false
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
        this.deTaiService.capNhatFileMinhChung(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message

                )
                if (this.detai && this.detai.sanpham && this.detai.sanpham.minhchung) {
                    this.detai.sanpham.minhchung.url = data.url;
                    this.detai.sanpham.minhchung.loaiminhchung = data.loaiminhchung ?? undefined
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
        this.deTaiService.capNhatVaiTroTacGia(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                console.log(response)
                if (this.detai && this.detai.sanpham_tacgias) {
                    this.detai.sanpham_tacgias = response.data
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

    onCapNhatTrangThai(deTai:ChiTietDeTai,trangthai:TrangThaiSanPham){
        this.isChangeStatus = true;

        const data:CapNhatTrangThaiSanPham = {
            trangthairasoat: trangthai
        }

        this.deTaiService.capNhatTrangThaiSanPham(deTai.sanpham.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.detai.sanpham.trangthairasoat = trangthai

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isChangeStatus = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isChangeStatus = false
            }
        })
    }

    onHoanTacXoaDeTai(deTai:ChiTietDeTai){
        this.isRestore = true;
        this.deTaiService.hoanTacXoaDeTai(deTai.sanpham.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.detai.deleted_at = undefined
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isRestore = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isRestore = false
            }
        })
    }

    getVaiTroTacGia(){
        this.isGetVaiTro = true
        this.vaiTroService.getVaiTroDeTai().pipe(
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

    onTuyenChonDeTai(){
        const form = this.formTuyenChon

        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                "Vui lòng nhập đúng yêu cầu của form"
            )

            return;
        }

        const data:TuyenChonDeTai = form.value

        this.isTuyenChon = true

        this.deTaiService.tuyenChonDeTai(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                if(data.ketquatuyenchon === this.AppConstant.TT_DETAI_SUCCESS){
                    this.detai.trangthai = this.AppConstant.CHO_XET_DUYET
                }else{
                    this.detai.trangthai = this.AppConstant.TUYEN_CHON_THAT_BAI
                }
                // thiếu trả về vm add vào this.detai
                this.isTuyenChon = false
                this.isOpenFormTuyenChon = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isTuyenChon = false
            }
        })
    }

    onXetDuyetDeTai(){
        const form = this.formXetDuyet

        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                "Vui lòng nhập đúng yêu cầu của form"
            )

            return;
        }

        const data:XetDuyetDeTai = {
            ...form.value,
            ngayxetduyet : dateConvert(form.get("ngayxetduyet")?.value.toString()),
            ngaykyhopdong: form.get("ngaykyhopdong")?.value !== null ? dateConvert(form.get("ngaykyhopdong")?.value.toString) : null
        }

        this.isXetDuyet = true

        this.deTaiService.xetDuyetDeTai(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                if(data.ketquaxetduyet === this.AppConstant.TT_DETAI_SUCCESS){
                    this.detai.trangthai = this.AppConstant.CHO_NGHIEM_THU
                }else{
                    this.detai.trangthai = this.AppConstant.XET_DUYET_THAT_BAI
                }
                // thiếu trả về vm add vào this.detai
                this.isXetDuyet = false
                this.isOpenFormXetDuyet = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isXetDuyet = false
            }
        })
    }

    onNghiemThuDeTai(){
        const form = this.formNghiemThu

        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                "Vui lòng nhập đúng yêu cầu của form"
            )

            return;
        }

        const data:NghiemThuDeTai = {
            ...form.value,
            ngaynghiemthu: form.get("ngaynghiemthu")?.value !== null ? dateConvert(form.get("ngaynghiemthu")?.value.toString()) : null,
            ngaycongnhanhoanthanh: form.get("ngaycongnhanhoanthanh")?.value !== null ? dateConvert(form.get("ngaycongnhanhoanthanh")?.value.toString()) : null
        }

        this.isNghiemThu = true
        this.deTaiService.nghiemThuDeTai(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.detai.trangthai = this.AppConstant.NGHIEM_THU
                // thiếu trả về vm add vào this.detai
                this.isNghiemThu = false
                this.isOpenFormNghiemThu = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isNghiemThu = false
            }
        })
    }


    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
        this.pagingService.resetValues()
    }
}