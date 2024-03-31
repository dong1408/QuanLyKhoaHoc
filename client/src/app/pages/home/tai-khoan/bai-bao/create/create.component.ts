import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzNotificationService} from "ng-zorro-antd/notification";
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
import {KeKhaiToChuc, ToChuc} from "../../../../../core/types/user-info/to-chuc.type";
import {KeKhaiTapChi, Magazine} from "../../../../../core/types/tapchi/tap-chi.type";
import {VaiTroTacGia} from "../../../../../core/types/sanpham/vai-tro-tac-gia.type";
import { User } from "src/app/core/types/user/user.type";
import {LoadingService} from "../../../../../core/services/loading.service";
import { ToChucService } from "src/app/core/services/user-info/to-chuc.service";
import {TapChiService} from "../../../../../core/services/tapchi/tap-chi.service";
import {UserService} from "../../../../../core/services/user/user.service";
import {PagingService} from "../../../../../core/services/paging.service";
import {VaiTroService} from "../../../../../core/services/sanpham/vai-tro.service";
import {BaiBaoService} from "../../../../../core/services/baibao/bai-bao.service";
import {noWhiteSpaceValidator} from "../../../../../shared/validators/no-white-space.validator";
import {TaoBaiTao} from "../../../../../core/types/baibao/bai-bao.type";
import {dateConvert} from "../../../../../shared/commons/utilities";
import {ApiResponse} from "../../../../../core/types/api-response.type";
import {KeKhaiKeyword, Keyword} from "../../../../../core/types/baibao/keyword.type";
import {HocHamHocVi} from "../../../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {KeywordService} from "../../../../../core/services/baibao/keyword.service";
import {HocHamHocViService} from "../../../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {NzUploadFile} from "ng-zorro-antd/upload";

@Component({
    selector:"app-taikhoan-baibao-create",
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class BaiBaoCreateComponent implements OnInit,OnDestroy{

    fileList:NzUploadFile[] = []

    keKhaiToChuc:any = []
    keKhaiKeyword:any = []
    keKhaiTapChi:any = []

    tochucs:ToChuc[] = []
    tapChis:Magazine[] = []
    vaiTros:VaiTroTacGia[] = []
    users:User[] = []
    keywords:Keyword[] = []
    dvTaiTros:ToChuc[] = []
    hhhvs:HocHamHocVi[] = []

    createForm:FormGroup
    tochucForm:FormGroup
    keywordForm:FormGroup
    tapchiForm:FormGroup

    isCreate:boolean = false
    isGetUsers:boolean = false
    isGetToChuc: boolean = false
    isGetKeyword:boolean = false
    isGetTapChi:boolean = false
    isGetTaiTro:boolean = false

    destroy$ = new Subject<void>()

    searchUser$ = new BehaviorSubject('');
    searchToChuc$ = new BehaviorSubject('');
    searchKeyword$ = new BehaviorSubject('');
    searchTapChi$ = new BehaviorSubject('');
    searchTaiTro$ = new BehaviorSubject('');


    // form
    isOpenFormToChuc:boolean = false
    isOpenFormTapChi:boolean = false
    isOpenFormKeyword:boolean = false


    isOpenListToChucKeKhai:boolean = false
    isOpenListKeyword:boolean = false
    isOpenListTapChi:boolean = false

    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private toChucService:ToChucService,
        private tapChiService:TapChiService,
        private userService:UserService,
        private pagingService:PagingService,
        private vaiTroService:VaiTroService,
        private baiBaoService:BaiBaoService,
        private keywordService:KeywordService,
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
            thoidiemcongbohoanthanh:[
                null,
                Validators.compose([
                    Validators.required
                ])
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

            users:[
                null
            ],
            doi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            url:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            received:[
                null,
                Validators.compose([
                ])
            ],
            accepted:[
                null,
                Validators.compose([
                ])
            ],
            published:[
                null,
                Validators.compose([
                ])
            ],
            abstract:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            keywords:[
                null,
                Validators.compose([
                ])
            ],
            volume:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            issue:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            number:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            pages:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            id_tapchi:[
                null,
                Validators.compose([
                    Validators.required
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

        this.keywordForm = this.fb.group({
            id:[
                null
            ],
            name:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ]
        })

        this.tapchiForm = this.fb.group({
            id:[
                null
            ],
            name:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            issn:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            eissn:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            pissn:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            website:[
                null,
                Validators.compose([
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

        this.onGetSearchUser()
        this.onGetSearchDVTaiTro()
        this.onGetSearchKeyword()
        this.onGetSearchTapChi()
        this.onGetSearchToChuc()
        this.loadingService.startLoading()
        forkJoin([
            this.vaiTroService.getVaiTroBaiBao(),
            this.hhhvService.getAllHocHamHocVi()
        ],(vtResponse,hhResponse) => {
            return {
                listVT: vtResponse.data,
                listhh: hhResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.vaiTros = response.listVT
                this.hhhvs = response.listhh
                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.loadingService.stopLoading()
            }
        })
    }

    onXoaToChucKeKhai(tentochuc:string){
        this.keKhaiToChuc = this.keKhaiToChuc.filter((item:KeKhaiToChuc) => item.tentochuc !== tentochuc)
        this.createForm.get("donvi")?.reset()
        this.sanphamTacgiaControls.forEach((control) => {
            if(control.get("in_system")?.value === false){
                control.get("tochuc")?.reset()
            }
        })
        this.dvTaiTros = this.dvTaiTros.filter((item:ToChuc) => item.tentochuc !== tentochuc)
    }

    onXoaTapChiKeKhai(tentapchi:string){
        this.keKhaiTapChi = this.keKhaiTapChi.filter((item:KeKhaiTapChi) => item.name !== tentapchi)
        this.createForm.get("tapchi")?.reset()
        this.tapChis = this.tapChis.filter((item:Magazine) => item.name !== tentapchi)
    }

    onXoaKeyword(name:string){
        this.keKhaiKeyword = this.keKhaiKeyword.filter((item:KeKhaiKeyword) => item.name !== name)
        this.createForm.get("keywords")?.reset()
        this.keywords = this.keywords.filter((item:Keyword) => item.name !== name)
    }

    onOpenFormToChuc(){
        this.tochucForm.reset()
        this.isOpenFormToChuc = !this.isOpenFormToChuc
    }

    onOpenListToChucKeKhai(){
        this.isOpenListToChucKeKhai = !this.isOpenListToChucKeKhai
    }

    onOpenListTapChiKeKhai(){
        this.isOpenListTapChi = !this.isOpenListTapChi
    }

    onOpenListKeyword(){
        this.isOpenListKeyword = !this.isOpenListKeyword
    }

    onOpenFormKeyword(){
        this.keywordForm.reset()
        this.isOpenFormKeyword = !this.isOpenFormKeyword
    }

    onOpenFormTapChi(){
        this.tapchiForm.reset()
        this.isOpenFormTapChi = !this.isOpenFormTapChi
    }

    onKeKhaiKeyword(){
        const form = this.keywordForm
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

        const isAvailable = this.keKhaiKeyword.some((item:KeKhaiKeyword) => {
            return item.name.toLowerCase() === data.name.toLowerCase()
        })

        if(isAvailable){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Bạn đã kê khai keyword này trước đó'
            )
            return;
        }

        this.keKhaiKeyword.push(data)
        this.keywords.push(data)
        form.reset()

        this.notificationService.create(
            'success',
            'Thành Công',
            'Kê khai keyword mới thành công, vui lòng chọn'
        )
    }



    onKeKhaiTapChi(){
        const form = this.tapchiForm
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

        const isAvailable = this.keKhaiTapChi.some((item:KeKhaiTapChi) => {
            return item.name.toLowerCase() === data.name.toLowerCase()
        })

        if(isAvailable){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Bạn đã kê khai tạp chí này trước đó'
            )
            return;
        }

        this.keKhaiTapChi.push(data)
        this.tapChis.push(data)
        form.reset()

        this.notificationService.create(
            'success',
            'Thành Công',
            'Kê khai tạp chí mới thành công, vui lòng chọn'
        )

        this.isOpenFormTapChi =false
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
        this.dvTaiTros.push(data)

        form.reset()

        this.notificationService.create(
            'success',
            'Thành Công',
            'Kê khai tổ chức mới thành công, vui lòng chọn'
        )

        this.isOpenFormToChuc =false
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
        const formArray = this.createForm.get('sanpham_tacgia') as FormArray
        formArray.push(control)

        this.notificationService.create(
            'success',
            'Thành Công',
            'Chọn tác giả ngoài hệ thống thành công'
        )
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



    onGetSearchKeyword(){
        const listKeyword = (keyword:string):Observable<ApiResponse<Keyword[]>> =>  this.keywordService.getAllKeyword(keyword)
        const optionList$:Observable<ApiResponse<Keyword[]>> = this.searchKeyword$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listKeyword))

        optionList$.subscribe(data => {
            this.keywords = data.data

            this.keywords = [...this.keKhaiKeyword,...this.keywords]
            this.isGetKeyword = false
        })
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

    onGetSearchTapChi(){
        const listTapChi = (keyword:string):Observable<ApiResponse<Magazine[]>> =>  this.tapChiService.getAllTapChi(keyword)
        const optionList$:Observable<ApiResponse<Magazine[]>> = this.searchTapChi$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listTapChi))

        optionList$.subscribe(data => {
            this.tapChis = data.data

            this.tapChis = [...this.keKhaiTapChi,...this.tapChis]
            this.isGetTapChi = false
        })
    }

    onSearchUser(event:any){
        if(event && event !== ""){
            this.isGetUsers = true
            this.searchUser$.next(event)
        }
    }

    onSearchTapChi(event:any){
        if(event && event !== ""){
            this.isGetTapChi = true
            this.searchTapChi$.next(event)
        }
    }

    onSearchKeyword(event:any){
        if(event && event !== ""){
            this.isGetKeyword = true
            this.searchKeyword$.next(event)
        }
    }

    onSearchToChuc(event:any){
        if(event && event !== ""){
            this.isGetToChuc = true
            this.searchToChuc$.next(event)
        }
    }

    onSearchTaiTro(event:any){
        if(event && event !== ""){
            this.isGetTaiTro = true
            this.searchTaiTro$.next(event)
        }
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

        this.isCreate = true
        const formData = new FormData()
        formData.append("file",form.get('file')?.value)

        this.baiBaoService.uploadFileMinhChung(formData).pipe(
            takeUntil(this.destroy$),
            mergeMap(response =>{

                const data:TaoBaiTao = {
                    sanpham:{
                        tensanpham: form.get('tensanpham')?.value,
                        tongsotacgia: arrayForm.length,
                        thoidiemcongbohoanthanh:  dateConvert(form.get('thoidiemcongbohoanthanh')?.value.toString())!!,
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
                    doi:form.get('doi')?.value,
                    url:form.get('url')?.value,
                    received:form.get('received')?.value ? dateConvert(form.get('received')?.value.toString()) : null,
                    accepted:form.get('accepted')?.value ? dateConvert(form.get('accepted')?.value.toString()) : null,
                    published:form.get('published')?.value ? dateConvert(form.get('published')?.value.toString()) : null,
                    abstract:form.get('abstract')?.value,
                    keywords:form.get('keywords')?.value !== null ? form.get('keywords')?.value.map((item:Keyword) => {
                        return {
                            id_keyword:item.id,
                            name:item.name
                        }
                    }) : null,

                    tapchi:{
                        id_tapchi: form.get("id_tapchi")?.value['id'] ?? null,
                        name:form.get("id_tapchi")?.value['name'],
                        issn:form.get("id_tapchi")?.value['issn'] ?? null,
                        eissn:form.get("id_tapchi")?.value['eissn'] ?? null,
                        pissn:form.get("id_tapchi")?.value['pissn'] ?? null,
                        website:form.get("id_tapchi")?.value['website'] ?? null
                    },
                    volume:form.get('volume')?.value,
                    issue:form.get('issue')?.value,
                    number:form.get('number')?.value,
                    pages:form.get('pages')?.value,
                }

                return this.baiBaoService.taoBaiBao(data)
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
                this.keKhaiTapChi.clear()
                this.keKhaiKeyword.clear()
                this.keKhaiToChuc.clear()
                this.fileList = []
                this.createForm.reset()
            },
            error:(error) => {
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
                        noWhiteSpaceValidator()
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