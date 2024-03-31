import {Component, OnDestroy, OnInit} from "@angular/core";
import {KeKhaiToChuc, ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {VaiTroTacGia} from "../../../core/types/sanpham/vai-tro-tac-gia.type";
import {User} from "../../../core/types/user/user.type";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {
    BehaviorSubject,
    combineLatest,
    debounceTime,
    distinctUntilChanged,
    forkJoin, mergeMap,
    Observable, Observer,
    Subject,
    switchMap,
    takeUntil,
    tap
} from "rxjs";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {UserService} from "../../../core/services/user/user.service";
import {PagingService} from "../../../core/services/paging.service";
import {VaiTroService} from "../../../core/services/sanpham/vai-tro.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../shared/validators/valid-value.validator";
import {TaoDeTai} from "../../../core/types/detai/de-tai.type";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";
import {PhanLoaiDeTaiService} from "../../../core/services/detai/phan-loai-de-tai.service";
import {PhanLoaiDeTai} from "../../../core/types/detai/phan-loai-de-tai.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {ApiResponse} from "../../../core/types/api-response.type";
import {HocHamHocViService} from "../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {HocHamHocVi} from "../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {NzUploadFile} from "ng-zorro-antd/upload";

@Component({
    selector:'app-detai-create',
    styleUrls:['./create.component.css'],
    templateUrl:'./create.component.html'
})

export class TaoDeTaiComponent implements OnInit,OnDestroy{

    fileList:NzUploadFile[] = []

    dvTaiTros:ToChuc[] = []
    tcChuQuan:ToChuc[]= []
    tcHopTac:ToChuc[]= []
    tochucs:ToChuc[]= []

    vaiTros:VaiTroTacGia[]= []
    hhhvs:HocHamHocVi[]= []
    phanLoais:PhanLoaiDeTai[]= []


    keKhaiToChuc:any = []

    users:User[]= []

    createForm:FormGroup
    tochucForm:FormGroup

    isCreate:boolean = false
    isGetUsers:boolean = false
    isGetTaiTro:boolean = false
    isGetChuQuan:boolean = false
    isGetHopTac:boolean = false
    isGetToChuc: boolean = false


    //
    isOpenListToChucKeKhai:boolean = false

    isOpenFormToChuc:boolean = false

    destroy$ = new Subject<void>()

    searchTaiTro$ = new BehaviorSubject('');
    searchChuQuan$ = new BehaviorSubject('');
    searchHopTac$ = new BehaviorSubject('');
    searchUser$ = new BehaviorSubject('');
    searchToChuc$ = new BehaviorSubject('');

    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private toChucService:ToChucService,
        private userService:UserService,
        private pagingService:PagingService,
        private vaiTroService:VaiTroService,
        private deTaiService:DeTaiService,
        private phanLoaiDeTaiService:PhanLoaiDeTaiService,
        private hhhvService:HocHamHocViService
    ) {
    }

    ngOnInit() {
        this.createForm = this.fb.group({
            tensanpham:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            tongsotacgia:[
                0,
                Validators.compose([
                    Validators.required
                ])
            ],
            conhantaitro:[
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            chitietdonvitaitro:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    noWhiteSpaceValidator()
                ]),
            ],
            donvi:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            sanpham_tacgia:this.fb.array([]),

            users: [
                null
            ],

            //
            maso:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            ngoaitruong:[
                false,
            ],

            // nếu ngoài trường === true
            truongchutri:[
                {
                    value:false,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            tochucchuquan:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            // nếu ngoaitruong === false
            id_loaidetai:[
                {
                    value:null,
                    disabled:false
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            detaihoptac:[
                false
            ],
            //nếu detaihoptac === true
            tochuchoptac:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            tylekinhphidonvihoptac:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],

            //
            capdetai:[
                null,
                Validators.compose([
                    validValuesValidator(['Khoa','Cơ sở','Tỉnh','Bộ','Ngành','Nhà nước','Nước ngoài']),
                    noWhiteSpaceValidator()
                ])
            ],
            file:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ]

        })

        this.tochucForm = this.fb.group({
            id:[
                null
            ],
            tentochuc:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
        })

        this.createForm.get("conhantaitro")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("donvi")?.enable()
                this.createForm.get("chitietdonvitaitro")?.enable()
            }else{
                this.createForm.get("chitietdonvitaitro")?.disable()
                this.createForm.get("donvi")?.disable()
                this.createForm.get("chitietdonvitaitro")?.reset()
                this.createForm.get("donvi")?.reset()
            }
        })

        this.createForm.get("cothongtindonvikhac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("id_thongtinnoikhac")?.enable()
            }else{
                this.createForm.get("id_thongtinnoikhac")?.disable()
                this.createForm.get("id_thongtinnoikhac")?.reset()
            }
        })

        this.createForm.get("detaihoptac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("tochuchoptac")?.enable()
                this.createForm.get("tylekinhphidonvihoptac")?.enable()
            }else{
                this.createForm.get("tochuchoptac")?.disable()
                this.createForm.get("tylekinhphidonvihoptac")?.disable()
                this.createForm.get("tochuchoptac")?.reset()
                this.createForm.get("tylekinhphidonvihoptac")?.reset()
            }
        })

        this.createForm.get("ngoaitruong")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("truongchutri")?.enable()
                this.createForm.get("tochucchuquan")?.enable()

                this.createForm.get("id_loaidetai")?.disable()
                this.createForm.get("id_loaidetai")?.reset()
            }else{
                this.createForm.get("truongchutri")?.disable()
                this.createForm.get("tochucchuquan")?.disable()
                this.createForm.get("tochucchuquan")?.reset()
                this.createForm.get("truongchutri")?.reset()

                this.createForm.get("id_loaidetai")?.enable()
            }
        })

        this.onGetSearchDVTaiTro()
        this.onGetSearchUser()
        this.onGetSearchToChuc()
        this.onGetSearchToChucHopTac()
        this.onGetSearchToChucChuQuan()
        this.loadingService.startLoading()
        forkJoin([
            this.vaiTroService.getVaiTroDeTai(),
            this.phanLoaiDeTaiService.getPhanLoaiDeTai(),
            this.hhhvService.getAllHocHamHocVi()
        ],(vtResponse,plResponse,hhResponse) => {
            return {
                listVT: vtResponse.data,
                listPL: plResponse.data,
                listHH:hhResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.vaiTros = response.listVT
                this.phanLoais = response.listPL
                this.hhhvs = response.listHH
                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Có lỗi xảy ra, vui lòng thử lại sau'
                )
                this.loadingService.stopLoading()
            }
        })
    }

    onOpenListToChucKeKhai(){
        this.isOpenListToChucKeKhai = !this.isOpenListToChucKeKhai
    }
    onXoaToChucKeKhai(tentochuc:string){
        this.keKhaiToChuc = this.keKhaiToChuc.filter((item:KeKhaiToChuc) => item.tentochuc !== tentochuc)
        this.createForm.get("tochucchuquan")?.reset()
        this.createForm.get("donvi")?.reset()
        this.createForm.get("tochuchoptac")?.reset()
        this.sanphamTacgiaControls.forEach((control) => {
            if(control.get("in_system")?.value === false){
                control.get("tochuc")?.reset()
            }
        })
        this.dvTaiTros = this.dvTaiTros.filter((item:ToChuc) => item.tentochuc !== tentochuc)
        this.tcChuQuan = this.tcChuQuan.filter((item:ToChuc) => item.tentochuc !== tentochuc)
        this.tcHopTac = this.tcHopTac.filter((item:ToChuc) => item.tentochuc !== tentochuc)
    }

    onOpenFormToChuc(){
        this.tochucForm.reset()
        this.isOpenFormToChuc = !this.isOpenFormToChuc
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

        const isAvailable = this.keKhaiToChuc.some((item:any) => {
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
        this.dvTaiTros.push(data)
        this.tcHopTac.push(data)
        this.tcChuQuan.push(data)

        form.reset()

        this.notificationService.create(
            'success',
            'Thành Công',
            'Kê khai tổ chức mới thành công, vui lòng chọn'
        )

        this.isOpenFormToChuc =false
    }

    // Tổ Chức USER

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

    onSearchToChuc(event:any){
        if(event && event !== ""){
            this.isGetToChuc = true
            this.searchToChuc$.next(event)
        }
    }

    //Tổ Chức Chủ Quản

    onGetSearchToChucChuQuan(){
        const listDVChuQuan = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchChuQuan$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listDVChuQuan))

        optionList$.subscribe(data => {
            this.tcChuQuan = data.data

            this.tcChuQuan = [...this.keKhaiToChuc,...this.tcChuQuan]
            this.isGetChuQuan = false
        })
    }

    onSearchToChucChuQuan(event:any){
        if(event && event !== ""){
            this.isGetChuQuan = true
            this.searchChuQuan$.next(event)
        }
    }

    //Tổ Chức Hợp Tác

    onGetSearchToChucHopTac(){
        const listDVHopTac = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchHopTac$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listDVHopTac))

        optionList$.subscribe(data => {
            this.tcHopTac = data.data

            this.tcHopTac = [...this.keKhaiToChuc,...this.tcHopTac]
            this.isGetHopTac = false
        })
    }

    onSearchToChucHopTac(event:any){
        if(event && event !== ""){
            this.isGetHopTac = true
            this.searchHopTac$.next(event)
        }
    }


    //DV Tài Trợ
    onGetSearchDVTaiTro(){
        const listDVTraiTro = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchTaiTro$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listDVTraiTro))

        optionList$.subscribe(data => {
            this.dvTaiTros = data.data

            this.dvTaiTros = [...this.keKhaiToChuc,...this.dvTaiTros]
            this.isGetTaiTro = false
        })
    }

    onSearchTaiTro(event:any){
        if(event && event !== ""){
            this.isGetTaiTro = true
            this.searchTaiTro$.next(event)
        }
    }

    //USER
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

    onSearchUser(event:any){
        if(event && event !== ""){
            this.isGetUsers = true
            this.searchUser$.next(event)
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
            id_vaitro:[null],
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
        const formArray = this.createForm.get('sanpham_tacgia') as FormArray
        formArray.push(control)
        this.notificationService.create(
            'success',
            'Thành Công',
            'Chọn tác giả ngoài hệ thống thành công'
        )

    }



    onSubmit(){
        const form = this.createForm
        const arrayForm = this.createForm.get('sanpham_tacgia') as FormArray
        if(form.invalid || arrayForm.invalid){
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
        if(arrayForm.length <= 0){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng chọn tác giả'
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

        this.isCreate = true
        const formData = new FormData()
        formData.append("file",form.get('file')?.value)

        this.deTaiService.uploadFileMinhChung(formData).pipe(
            takeUntil(this.destroy$),
            mergeMap(response => {
                const data:TaoDeTai = {
                    sanpham:{
                        tensanpham: form.get('tensanpham')?.value,
                        tongsotacgia: arrayForm.length,
                        conhantaitro : form.get('conhantaitro')?.value ?? false,
                        donvi :form.get('conhantaitro')?.value === true ? {
                            id_donvi: form.get('donvi')?.value['id'] ?? null,
                            tentochuc: form.get('donvi')?.value['tentochuc']
                        } : null,
                        chitietdonvitaitro: form.get('conhantaitro')?.value === true ? form.get('chitietdonvitaitro')?.value : null
                    },
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
                    fileminhchungsanpham:{
                        file: response.data.link_view,
                        id_file: response.data.file_id
                    },
                    maso:form.get('maso')?.value,
                    ngoaitruong:form.get('ngoaitruong')?.value ?? false,
                    truongchutri: form.get('ngoaitruong')?.value === true ? form.get('truongchutri')?.value : null,
                    tochucchuquan : form.get('ngoaitruong')?.value === true ? {
                        id_tochucchuquan:form.get('tochucchuquan')?.value['id'] ?? null,
                        tentochuc: form.get('tochucchuquan')?.value['tentochuc'],
                    } : null,
                    id_loaidetai: form.get('ngoaitruong')?.value === false ? form.get('id_loaidetai')?.value : null,
                    detaihoptac: form.get('detaihoptac')?.value ?? false,
                    tochuchoptac: form.get('detaihoptac')?.value === true ? {
                        id_tochuchoptac:form.get('tochuchoptac')?.value['id'] ?? null,
                        tentochuc: form.get('tochuchoptac')?.value['tentochuc'],
                    } : null,
                    tylekinhphidonvihoptac: form.get('detaihoptac')?.value === true ? form.get('tylekinhphidonvihoptac')?.value : null,
                    capdetai: form.get('capdetai')?.value ?? null
                }

                return this.deTaiService.taoDeTai(data)
            })
        ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.isCreate = false
                const formArray = this.createForm.get('sanpham_tacgia') as FormArray
                formArray.clear()
                this.keKhaiToChuc.clear()
                this.createForm.reset()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isCreate = false
            }
        })
    }

    onSelectUser(event:any){
        if(!event){
            return;
        }
        else{
            const data:User = event;
            const formArray = this.createForm.get('sanpham_tacgia') as FormArray
            const isUserAvailable = formArray.value.some((item:any) => {
                return item.id_tacgia === data.id
            })
            if(isUserAvailable){
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Vui lòng không chọn 2 tác giả giống nhau'
                )
                this.createForm.get("users")?.setValue(null)
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
                email:[
                    data.email
                ]
            })
            formArray.push(control);
            this.createForm.get("users")?.setValue(null)
            this.notificationService.create(
                'success',
                'Thành Công',
                'Chọn tác giả thành công'
            )
        }
    }

    removeUser(index:number){
        (this.createForm.get('sanpham_tacgia') as FormArray).removeAt(index);
        this.notificationService.create(
            'success',
            'Thành Công',
            'Xóa thành công'
        )
    }

    get sanphamTacgiaControls() {
        return (this.createForm.get('sanpham_tacgia') as FormArray).controls;
    }

    beforeUpload = (file: NzUploadFile):Observable<boolean> =>
        new Observable((observer: Observer<boolean>) => {
            file.status = "uploading"
            const extension = file.name.split('.').pop()?.toLowerCase();

            const isTypeSuccess = extension === 'docx' || extension === 'pdf' || file.type! === 'image/jpeg' || file.type! === 'image/png'

            if(!isTypeSuccess){
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Chỉ chấp nhận các file .docx, .pdf, jpeg, png'
                )
                observer.complete
                return;
            }

            const isLessThan10MB = file.size! / 1024 / 1024 <= 10;

            if(!isLessThan10MB){
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Chỉ chấp nhận file nhỏ hơn 10MB'
                )
                file.status = "error"
                observer.complete();
                return;
            }

            if(this.fileList.length >= 1){
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Chỉ được upload 1 file'
                )
                file.status = "error"
                observer.complete();
                return;
            }

            observer.next(false);
            this.fileList = this.fileList.concat(file)
            this.createForm.patchValue({
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