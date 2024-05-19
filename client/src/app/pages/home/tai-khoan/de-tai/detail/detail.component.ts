import {Component} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {
    BehaviorSubject,
    combineLatest,
    debounceTime,
    distinctUntilChanged,
    Observable, Observer,
    Subject,
    switchMap,
    takeUntil,
    tap
} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {ChiTietDeTai, NghiemThuDeTai, TuyenChonDeTai, XetDuyetDeTai} from "src/app/core/types/detai/de-tai.type";
import {User} from "../../../../../core/types/user/user.type";
import {CapNhatVaiTroTacGia, SanPhamTacGia, VaiTroTacGia} from "../../../../../core/types/sanpham/vai-tro-tac-gia.type";
import {LoadingService} from "../../../../../core/services/loading.service";
import {DeTaiService} from "../../../../../core/services/detai/de-tai.service";
import {UserService} from "../../../../../core/services/user/user.service";
import {PagingService} from "../../../../../core/services/paging.service";
import {VaiTroService} from "../../../../../core/services/sanpham/vai-tro.service";
import {ConstantsService} from "../../../../../core/services/constants.service";
import {noWhiteSpaceValidator} from "../../../../../shared/validators/no-white-space.validator";
import {CapNhatFileMinhChung} from "../../../../../core/types/sanpham/file-minh-chung.type";
import {KeKhaiToChuc, ToChuc} from "../../../../../core/types/user-info/to-chuc.type";
import {ApiResponse} from "../../../../../core/types/api-response.type";
import {dateConvert, mergedUsers} from "../../../../../shared/commons/utilities";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../../../../core/types/sanpham/san-pham.type";
import {HocHamHocVi} from "../../../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {HocHamHocViService} from "../../../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {ToChucService} from "../../../../../core/services/user-info/to-chuc.service";
import {NzUploadFile} from "ng-zorro-antd/upload";
import {validateFileUpload} from "../../../../../shared/validators/file-upload.validator";

@Component({
    selector:'app-taikhoan-detai-chitiet',
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class ChiTietDeTaiComponent{
    id:number
    fileList:NzUploadFile[] = []

    keKhaiToChuc:any = []

    formCapNhatFileMinhChung:FormGroup
    formCapNhatTacGia:FormGroup
    tochucForm:FormGroup

    isCapNhatFileMinhChung:boolean = false
    isOpenFormMinhChung:boolean = false
    isCapNhatTacGia:boolean = false
    isOpenFormTacGia:boolean = false
    isGetUsers:boolean = false
    isGetVaiTro:boolean =false
    isOpenFormToChuc:boolean = false
    isOpenListToChucKeKhai:boolean = false
    isGetHocHamHocVi:boolean = false

    tochucs:ToChuc[] = []

    isGetToChuc: boolean = false

    searchToChuc$ = new BehaviorSubject('');
    searchUser$ = new BehaviorSubject('');

    detai:ChiTietDeTai
    users:User[]
    vaiTros:VaiTroTacGia[]
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
        private hocHamHocViService:HocHamHocViService,
        private toChucService:ToChucService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/home/tai-khoan/san-pham/de-tai"])
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
            file:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ]
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
            return item.tentochuc.toLowerCase() === data.tentochuc.toLowerCase() || item.tentochuc.toLowerCase() === data.tentochuc.toLowerCase()
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

    onXoaToChucKeKhai(tentochuc:string){
        this.keKhaiToChuc = this.keKhaiToChuc.filter((item:KeKhaiToChuc) => item.tentochuc !== tentochuc)
        this.tochucs = this.tochucs.filter((item:ToChuc) => item.tentochuc !== tentochuc)
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
            const isUserAvailable = formArray.value.some((item:any) => {
                return item.id_tacgia === data.id
            })
            if(isUserAvailable){
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Vui lòng không chọn 2 tác giả giống nhau'
                )
                this.formCapNhatTacGia.get("users")?.setValue(null)
                return;
            }
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
            this.notificationService.create(
                'success',
                'Thành Công',
                'Chọn tác giả thành công'
            )
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
        this.notificationService.create(
            'success',
            'Thành Công',
            'Xóa thành công'
        )
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
        this.notificationService.create(
            'success',
            'Thành Công',
            'Chọn tác giả ngoài hệ thống thành công'
        )

    }

    onOpenFormCapNhatMinhChung(){
        this.isOpenFormMinhChung = !this.isOpenFormMinhChung
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

        const formData = new FormData()
        formData.append("file",data.file)
        this.isCapNhatFileMinhChung = true;
        this.deTaiService.capNhatFileMinhChung(this.id,formData)
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
                    this.detai.sanpham.minhchung.url = response.data;
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
                this.keKhaiToChuc = []
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

    beforeUpload = (file: NzUploadFile):Observable<boolean> =>
        new Observable((observer: Observer<boolean>) => {
            const errorMessage = validateFileUpload(file,this.fileList)

            if (errorMessage) {
                this.notificationService.create('error', 'Lỗi', errorMessage);
                observer.complete();
                return;
            }

            observer.next(false);
            this.fileList = this.fileList.concat(file)
            this.formCapNhatFileMinhChung.patchValue({
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