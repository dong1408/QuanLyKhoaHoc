import {Component} from "@angular/core";
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
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {ChiTietBaiBao} from "../../../core/types/baibao/bai-bao.type";
import {BaiBaoService} from "../../../core/services/baibao/bai-bao.service";
import {CapNhatTrangThaiSanPham, TrangThaiSanPham} from "../../../core/types/sanpham/san-pham.type";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {CapNhatFileMinhChung} from "../../../core/types/sanpham/file-minh-chung.type";
import {CapNhatVaiTroTacGia, SanPhamTacGia, VaiTroTacGia} from "../../../core/types/sanpham/vai-tro-tac-gia.type";
import {UserService} from "../../../core/services/user/user.service";
import {PagingService} from "../../../core/services/paging.service";
import {User} from "../../../core/types/user/user.type";
import {VaiTroService} from "../../../core/services/sanpham/vai-tro.service";
import {ConstantsService} from "../../../core/services/constants.service";
import {KeKhaiToChuc, ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {ApiResponse} from "../../../core/types/api-response.type";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {HocHamHocVi} from "../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {HocHamHocViService} from "../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {dateConvert, mergedUsers} from "../../../shared/commons/utilities";

@Component({
    selector:"app-baibao-chitiet",
    templateUrl:'./detail.component.html',
    styleUrls:['./detail.component.css']
})

export class ChiTietBaiBaoComponent{
    id:number

    keKhaiToChuc:any = []

    formCapNhatFileMinhChung:FormGroup
    formCapNhatTacGia:FormGroup
    tochucForm:FormGroup


    tochucs:ToChuc[] = []

    isGetToChuc: boolean = false

    searchToChuc$ = new BehaviorSubject('');
    searchUser$ = new BehaviorSubject('');

    isCapNhatFileMinhChung:boolean = false
    isOpenFormMinhChung:boolean = false
    isCapNhatTacGia:boolean = false
    isOpenFormTacGia:boolean = false
    isGetUsers:boolean = false
    isGetVaiTro:boolean =false
    isGetHocHamHocVi:boolean = false
    isOpenFormToChuc:boolean = false
    isOpenListToChucKeKhai:boolean = false


    isRestore:boolean = false
    isForceDelete:boolean = false
    isSoftDelete:boolean = false
    isChangeStatus:boolean = false
    isDelete:boolean = false

    baibao:ChiTietBaiBao
    users:User[] = []
    vaiTros:VaiTroTacGia[] = []

    hhhvs:HocHamHocVi[] = []

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
                this.router.navigate(["/admin/bai-bao"])
                return;
            }
        })

        this.formCapNhatTacGia = this.fb.group({
            sanpham_tacgia:this.fb.array([]),
            users:[
                null
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

        this.formCapNhatFileMinhChung = this.fb.group({
            url:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ]
        })

        this.onGetSearchToChuc()
        this.onGetSearchUser()
        this.getChiTietBaiBao()
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

    onOpenFormTacGia(isOpen : boolean){
        if(isOpen){
            this.isOpenFormTacGia = isOpen
            this.getVaiTroTacGia()
            this.onGetHHHV()
            // cập nhật lại dữ liệu tác giả trong form nếu bị tắt đột ngột
            const formArray = this.formCapNhatTacGia.get('sanpham_tacgia') as FormArray
            formArray.clear()
            this.initSanPhamTacGia(this.baibao.sanpham_tacgias)
        }else{
            this.isOpenFormTacGia = isOpen
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

    getChiTietBaiBao(){
        this.loadingService.startLoading()
        this.baiBaoService.getChiTietBaiBao(this.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao = response.data
                this.formCapNhatFileMinhChung.patchValue({
                    url: this.baibao.sanpham.minhchung?.url,
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
                this.router.navigate(['/bai-bao'])
                return;
            }
        })
    }

    onXoaMemBaiBao(baiBao:ChiTietBaiBao){
        this.isSoftDelete = true;
        this.baiBaoService.xoaMemBaiBao(baiBao.sanpham.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                baiBao.deleted_at = Date.now().toString()
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

    onXoaBaiBao(baiBao:ChiTietBaiBao){
        this.isDelete = true;
        this.baiBaoService.xoaBaiBao(baiBao.sanpham.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {

                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isDelete = false
                this.router.navigate(['/admin/bai-bao'])
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

    onCapNhatTrangThai(baiBao:ChiTietBaiBao,trangthai:TrangThaiSanPham){
        this.isChangeStatus = true;

        const data:CapNhatTrangThaiSanPham = {
            trangthairasoat: trangthai
        }

        this.baiBaoService.capNhatTrangThaiSanPham(baiBao.sanpham.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao.sanpham.trangthairasoat = trangthai

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

    onHoanTacXoaBaiBao(baiBao:ChiTietBaiBao){
        this.isRestore = true;
        this.baiBaoService.hoanTacXoaBaiBao(baiBao.sanpham.id).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao.deleted_at = undefined
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

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
        this.pagingService.resetValues()
    }
}