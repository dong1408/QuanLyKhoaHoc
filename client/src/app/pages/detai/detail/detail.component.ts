import {Component} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {
    BehaviorSubject,
    combineLatest,
    debounceTime,
    distinctUntilChanged,
    Observable,
    Subject,
    switchMap,
    takeUntil,
    tap
} from "rxjs";
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
import {dateConvert, mergedUsers} from "../../../shared/commons/utilities";
import {HocHamHocVi} from "../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {KeKhaiToChuc, ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {ApiResponse} from "../../../core/types/api-response.type";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {HocHamHocViService} from "../../../core/services/user-info/hoc-ham-hoc-vi.service";

@Component({
    selector:'app-detai-chitiet',
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class ChiTietDeTaiComponent{
    id:number

    keKhaiToChuc:any = []

    formCapNhatFileMinhChung:FormGroup
    formCapNhatTacGia:FormGroup
    formXetDuyet:FormGroup
    formNghiemThu:FormGroup
    formTuyenChon:FormGroup
    tochucForm:FormGroup

    isOpenFormTuyenChon:boolean = false
    isTuyenChon:boolean = false
    isOpenFormXetDuyet:boolean = false
    isXetDuyet:boolean = false
    isOpenFormNghiemThu:boolean = false
    isNghiemThu:boolean = false
    isOpenFormToChuc:boolean = false
    isOpenListToChucKeKhai:boolean = false


    isCapNhatFileMinhChung:boolean = false
    isOpenFormMinhChung:boolean = false
    isCapNhatTacGia:boolean = false
    isOpenFormTacGia:boolean = false
    isGetUsers:boolean = false
    isGetVaiTro:boolean =false
    isGetHocHamHocVi:boolean = false


    tochucs:ToChuc[] = []

    isGetToChuc: boolean = false

    searchToChuc$ = new BehaviorSubject('');
    searchUser$ = new BehaviorSubject('');

    isRestore:boolean = false
    isForceDelete:boolean = false
    isSoftDelete:boolean = false
    isChangeStatus:boolean = false
    isDelete:boolean = false

    detai:ChiTietDeTai
    users:User[] = []
    vaiTros:VaiTroTacGia[] = []
    hhhvs:HocHamHocVi[] = []

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
        public AppConstant:ConstantsService,
        private toChucService:ToChucService,
        private hocHamHocViService:HocHamHocViService
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
            ketquanghiemthu:[
                null,
                Validators.compose([
                    Validators.required,
                ])
            ],
            ngaynghiemthu:[
                null,
                Validators.compose([
                    Validators.required,
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
            ]
        })

        this.tochucForm = this.fb.group({
            id:[
                null
            ],
            matochuc:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            tentochuc:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
        })

        this.formXetDuyet.get("ketquaxetduyet")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === this.AppConstant.TT_DETAI_SUCCESS){
                this.formXetDuyet.get("sohopdong")?.enable()
                this.formXetDuyet.get("ngaykyhopdong")?.enable()
                this.formXetDuyet.get("thoihanhopdong")?.enable()
                this.formXetDuyet.get("kinhphi")?.enable()
            }else {
                this.formXetDuyet.get("sohopdong")?.reset()
                this.formXetDuyet.get("ngaykyhopdong")?.reset()
                this.formXetDuyet.get("thoihanhopdong")?.reset()
                this.formXetDuyet.get("kinhphi")?.reset()

                this.formXetDuyet.get("sohopdong")?.disable()
                this.formXetDuyet.get("ngaykyhopdong")?.disable()
                this.formXetDuyet.get("thoihanhopdong")?.disable()
                this.formXetDuyet.get("kinhphi")?.disable()
            }
        })

        this.formXetDuyet.get("ketquanghiemthu")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === this.AppConstant.TT_DETAI_SUCCESS){
                this.formXetDuyet.get("ngaycongnhanhoanthanh")?.enable()
                this.formXetDuyet.get("soqdcongnhanhoanthanh")?.enable()
            }else{
                this.formXetDuyet.get("ngaycongnhanhoanthanh")?.reset()
                this.formXetDuyet.get("soqdcongnhanhoanthanh")?.reset()

                this.formXetDuyet.get("ngaycongnhanhoanthanh")?.disable()
                this.formXetDuyet.get("soqdcongnhanhoanthanh")?.disable()
            }
        })

        this.onGetSearchUser()
        this.onGetSearchToChuc()

        this.getChiTietDeTai()
    }

    onKeKhaiToChuc(){
        const form = this.tochucForm
        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng điền đúng yêu cầu của form'
            )
            Object.values(form.controls).forEach(control =>{
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({ onlySelf: true });
                }
            })
            return;
        }
        const data = form.value

        // check kê khai trùng tổ chức

        const isAvailable = this.keKhaiToChuc.some((item:KeKhaiToChuc) => {
            return item.matochuc.toLowerCase() === data.matochuc.toLowerCase() || item.tentochuc.toLowerCase() === data.tentochuc.toLowerCase()
        })

        if(isAvailable){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Bạn đã kê khai tổ chức này trước đó'
            )
            return;
        }

        this.keKhaiToChuc.push(data)
        this.tochucs.push(data)

        form.reset()

        this.notificationService.create(
            'success',
            'Thành Công',
            'Kê khai tổ chức mới thành công, vui lòng chọn'
        )

        this.isOpenFormToChuc =false
    }

    onOpenFormToChuc(){
        this.tochucForm.reset()
        this.isOpenFormToChuc = !this.isOpenFormToChuc
    }

    onSearchToChuc(event:any){
        if(event && event !== ""){
            this.isGetToChuc = true
            this.searchToChuc$.next(event)
        }
    }

    onGetHHHV(){
        this.isGetHocHamHocVi = true
        this.hocHamHocViService.getAllHocHamHocVi()
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.hhhvs = response.data
                this.isGetHocHamHocVi = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isGetHocHamHocVi = false
                this.isOpenFormTacGia = false
            }
        })
    }

    onOpenListToChucKeKhai(){
        this.isOpenListToChucKeKhai = !this.isOpenListToChucKeKhai
    }

    onXoaToChucKeKhai(matochuc:string){
        this.keKhaiToChuc = this.keKhaiToChuc.filter((item:KeKhaiToChuc) => item.matochuc !== matochuc)
        this.tochucs = this.tochucs.filter((item:ToChuc) => item.matochuc !== matochuc)
        this.sanphamTacgiaControls.forEach((control) => {
            if(control.get("in_system")?.value === false){
                control.get("tochuc")?.reset()
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
                list_id_vaitro:[null],
                in_system:[
                    true
                ],
                // tochuc:[
                //     data.tochuc
                // ],
                email:[
                    data.email
                ]
            })
            formArray.push(control);
            this.formCapNhatTacGia.get("users")?.setValue(null)
        }
    }

    onGetSearchToChuc(){
        const listToChuc = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchToChuc$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listToChuc))

        optionList$.subscribe(data => {
            this.tochucs = data.data

            this.tochucs = [...this.keKhaiToChuc,...this.tochucs]
            this.isGetToChuc = false
        })
    }


    onSearchUser(event:any){
        if(event && event !== ""){
            this.isGetUsers = true
            this.searchUser$.next(event)
        }
    }

    onGetSearchUser(){
        const listUser = (keyword:string):Observable<ApiResponse<User[]>> =>  this.userService.getAllUsers(keyword)
        const optionList$:Observable<ApiResponse<User[]>> = this.searchUser$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listUser))

        optionList$.subscribe(data => {
            this.users = data.data
            this.isGetUsers = false
        })
    }
    removeUser(index:number){
        (this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray).removeAt(index);
    }

    get sanphamTacgiaControls() {
        return (this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray).controls;
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
            list_id_vaitro:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            ngaysinh:[
                null,
                Validators.compose([
                    Validators.required,
                ])
            ],
            dienthoai:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            email:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator(),
                    Validators.email,
                ])
            ],
            tochuc:[
                null,
                Validators.compose([
                    Validators.required,
                ])
            ],
            id_hochamhocvi:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            in_system:[
                false
            ]
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
            this.onGetHHHV()
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

        const data:CapNhatVaiTroTacGia = {
            sanpham_tacgia: form.get('sanpham_tacgia')?.value.map((item:any) => {
                let tochuc = item.tochuc ?? null
                return {
                    list_id_vaitro: item.list_id_vaitro,
                    tentacgia: item.tentacgia,
                    id_tacgia: item.id_tacgia ?? null,
                    ngaysinh: item.ngaysinh !== null ? dateConvert(item.ngaysinh) : null,
                    dienthoai: item.dienthoai ?? null,
                    email: item.email,
                    tochuc: tochuc !== null ?{
                        id_tochuc:tochuc.id ?? null,
                        matochuc:tochuc.matochuc,
                        tentochuc:tochuc.tentochuc
                    } : null,
                    id_hochamhocvi:item.id_hochamhocvi ?? null,
                    thutu:item.thutu ?? null,
                    tyledonggop:item.tyledonggop ?? null
                }
            }),
        }
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
    private initSanPhamTacGia(data:SanPhamTacGia[]){
        const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
        const dataFiltered = mergedUsers(data)
        dataFiltered.map((item:any) => {
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
                list_id_vaitro:[[...item.vaitrotacgia.map((item:any) => item.id)]],
                tochuc:[
                    item.tochuc !== null ? item.tochuc : null
                ],
                id_hochamhocvi:[
                    item.hochamhocvi !== null ? item.hochamhocvi.id : null
                ],
                email:[
                    item.email
                ],
                in_system:[
                    true
                ]
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

        if(data.ketquatuyenchon === this.AppConstant.TT_DETAI_FAILED && (data.lydo === null || data.lydo === "")){
            this.notificationService.create(
                'error',
                'Lỗi',
                "Vui lòng nhập lý do nếu kết quả tuyển chọn không đủ kiều kiện"
            )

            return;
        }

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
                    this.detai.tuyenchon = response.data
                }else{
                    this.detai.trangthai = this.AppConstant.TUYEN_CHON_THAT_BAI
                    this.detai.tuyenchon = response.data
                }
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
            ngaykyhopdong: form.get("ngaykyhopdong")?.value !== null ? dateConvert(form.get("ngaykyhopdong")?.value.toString()) : null
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
                    this.detai.xetduyet = response.data
                }else{
                    this.detai.trangthai = this.AppConstant.XET_DUYET_THAT_BAI
                    this.detai.xetduyet = response.data
                }
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
                this.detai.nghiemthu = response.data
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