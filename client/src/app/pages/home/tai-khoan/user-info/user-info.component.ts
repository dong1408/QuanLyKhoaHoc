import {Component} from "@angular/core";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ToChuc} from "../../../../core/types/user-info/to-chuc.type";
import {DonVi} from "../../../../core/types/user-info/don-vi.type";
import {NgachVienChuc} from "../../../../core/types/user-info/ngach-vien-chuc.type";
import {QuocGia} from "../../../../core/types/user-info/quoc-gia.type";
import {HocHamHocVi} from "../../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {ChuyenMon} from "../../../../core/types/user-info/chuyen-mon.type";
import {NganhTinhDiem} from "../../../../core/types/quydoi/nganh-tinh-diem.type";
import {ChuyenNganhTinhDiem} from "../../../../core/types/quydoi/chuyen-nganh-tinh-diem.type";
import {Role} from "../../../../core/types/roles/role.type";
import {ChangePassword, UpdateUser, UserDetail} from "../../../../core/types/user/user.type";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {UserService} from "../../../../core/services/user/user.service";
import {ToChucService} from "../../../../core/services/user-info/to-chuc.service";
import {HocHamHocViService} from "../../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {DonViService} from "../../../../core/services/user-info/don-vi.service";
import {NganhTinhDiemService} from "../../../../core/services/quydoi/nganh-tinh-diem.service";
import {ChuyenNganhTinhDiemService} from "../../../../core/services/quydoi/chuyen-nganh-tinh-diem.service";
import {ChuyenMonService} from "../../../../core/services/user-info/chuyen-mon.service";
import {QuocGiaService} from "../../../../core/services/user-info/quoc-gia.service";
import {NgachVienChucService} from "../../../../core/services/user-info/ngach-vien-chuc.service";
import {LoadingService} from "../../../../core/services/loading.service";
import {noWhiteSpaceValidator} from "../../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../../shared/validators/valid-value.validator";
import {dateConvert} from "../../../../shared/commons/utilities";
import {passwordsMatch} from "../../../../shared/validators/password-smatch.validator";
import {ApiResponse} from "../../../../core/types/api-response.type";

@Component({
    selector:"app-taikhoan-userinfo",
    templateUrl:'./user-info.component.html',
    styleUrls:['./user-info.component.css']
})

export class UserInfoComponent{
    id:number

    destroy$ = new Subject<void>()

    isGetDonViLoading:boolean = false
    isGetChuyenNganhTinhDiemLoading:boolean = false
    isUpdate:boolean = false
    changePasswordLoading:boolean = false

    updateForm:FormGroup
    formChangePassword:FormGroup

    isGetToChuc: boolean = false
    isGetNoiHoc: boolean = false

    searchToChuc$ = new BehaviorSubject('');
    searchNoiHoc$ = new BehaviorSubject('');

    tochucs:ToChuc[] = []
    noiHocs:ToChuc[] = []

    toChucs:ToChuc[] = []
    donVis:DonVi[] = []
    ngachVienChucs:NgachVienChuc[] = []
    quocTichs:QuocGia[] = []
    hocHams:HocHamHocVi[] = []
    chuyenMons:ChuyenMon[] = []
    nganhTinhDiem:NganhTinhDiem[] = []
    chuyenNganhTinhDiem:ChuyenNganhTinhDiem[] = []
    user:UserDetail

    constructor(
        private fb:FormBuilder,
        private notificationService:NzNotificationService,
        private userService:UserService,
        private toChucService:ToChucService,
        private hocHamHocViService:HocHamHocViService,
        private donViService:DonViService,
        private nganhTinhDiemService:NganhTinhDiemService,
        private chuyenNganhTinhDiemService:ChuyenNganhTinhDiemService,
        private chuyenMonService:ChuyenMonService,
        private quocGiaService:QuocGiaService,
        private ngachVienChucService:NgachVienChucService,
        public loadingService:LoadingService,
    ) {
    }

    ngOnInit() {
        this.updateForm = this.fb.group({
            name:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            username:[
                {
                    value:null,
                    disabled:true
                },
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
                    Validators.email
                ])
            ],
            ngaysinh:[
                null
            ],
            dienthoai:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            email2:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.email
                ])
            ],
            orchid:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            id_tochuc:[
                null,
            ],
            cohuu:[
                null,
            ],
            keodai:[
                null
            ],
            dinhmucnghiavunckh:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            dangdihoc:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(['caohoc','ncs'])
                ])
            ],
            id_noihoc:[
                null
            ],
            id_ngachvienchuc:[
                null
            ],
            id_quoctich:[
                null
            ],
            id_hochamhocvi:[
                null
            ],
            id_chuyenmon:[
                null
            ],
            id_nganhtinhdiem:[
                null
            ],
            id_chuyennganhtinhdiem:[
                null
            ]
        })

        this.formChangePassword = this.fb.group({
            passwordcurrent:[
                '',
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            password:[
                '',
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            password_confirmation:[
                '',
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ]
        },{
            validators: passwordsMatch('password','password_confirmation')
        })

        this.updateForm.get("dangdihoc")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select !== null){
                this.updateForm.get("id_noihoc")?.enable()
            }else{
                this.updateForm.get("id_noihoc")?.disable()
                this.updateForm.get("id_noihoc")?.reset()
            }
        })

        this.updateForm.get("id_nganhtinhdiem")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select !== null){
                this.updateForm.get("id_chuyennganhtinhdiem")?.reset()
                this.getChuyenNganhTinhDiem(select)
                this.updateForm.get("id_chuyennganhtinhdiem")?.enable()
            }else{
                this.updateForm.get("id_chuyennganhtinhdiem")?.disable()
                this.updateForm.get("id_chuyennganhtinhdiem")?.reset()
            }
        })

        this.onGetSearchNoiHoc()
        this.onGetSearchToChuc()

        this.loadingService.startLoading()
        forkJoin([
            this.hocHamHocViService.getAllHocHamHocVi(),
            this.ngachVienChucService.getAllNgachVienChuc(),
            this.chuyenMonService.getAllChuyeMon(),
            this.quocGiaService.getAllQuocGia(),
            this.nganhTinhDiemService.getNganhTinhDiem(),
            this.userService.getUserInfo(),
            this.chuyenNganhTinhDiemService.getChuyenNganhTinhDiem()
        ],(hhResponse,nvcResponse,cmResponse,qgResponse,ntdResponse,uResponse,cnResponse) => {
            return {
                listHH: hhResponse.data,
                listNVC: nvcResponse.data,
                listCM: cmResponse.data,
                listQG:qgResponse.data,
                listNTD:ntdResponse.data,
                user:uResponse.data,
                listCN:cnResponse.data,
            }
        }).subscribe({
            next:(response) =>{
                this.hocHams = response.listHH
                this.ngachVienChucs = response.listNVC
                this.chuyenMons = response.listCM
                this.quocTichs = response.listQG
                this.nganhTinhDiem = response.listNTD
                this.user = response.user
                this.chuyenNganhTinhDiem = response.listCN

                if(this.user.tochuc){
                    this.tochucs = [...this.tochucs,this.user.tochuc]
                }

                if(this.user.noihoc){
                    this.noiHocs = [...this.noiHocs,this.user.noihoc]
                }

                this.updateForm.patchValue({
                    username: this.user.username,
                    name: this.user.name,
                    email:this.user.email,
                    ngaysinh:this.user.ngaysinh ?? null,
                    dienthoai:this.user.dienthoai ?? null,
                    email2:this.user.email2 ?? null,
                    dangdihoc:this.user.dangdihoc ?? null,
                    orchid:this.user.orchid ?? null,
                    id_tochuc:this.user.tochuc?.id ?? null,
                    id_noihoc:this.user.noihoc?.id ?? null,
                    cohuu:this.user.cohuu ?? null,
                    keodai:this.user.keodai ?? null,
                    dinhmucnghiavunckh:this.user.dinhmucnghiavunckh ?? null,
                    id_ngachvienchuc: this.user.ngachvienchuc?.id ?? null,
                    id_quoctich: this.user.quoctich?.id ?? null,
                    id_hochamhocvi: this.user.hochamhocvi?.id ?? null,
                    id_chuyenmon: this.user.chuyenmon?.id ?? null,
                    id_nganhtinhdiem: this.user.nganhtinhdiem?.id ?? null,
                    id_chuyennganhtinhdiem: this.user.chuyennganhtinhdiem?.id ?? null
                })

                this.loadingService.stopLoading()
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.loadingService.stopLoading()
                return
            }
        })
    }

    getDonViByToChucId(id:number){
        this.isGetDonViLoading = true
        this.donViService.getAllByToChucId(id)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.donVis = response.data
                this.isGetDonViLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isGetDonViLoading = false
            }
        })
    }

    getChuyenNganhTinhDiem(id:number){
        this.isGetChuyenNganhTinhDiemLoading = true
        this.chuyenNganhTinhDiemService.getChuyenNganhTinhDiemByIdNganhTinhDiem(id)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.chuyenNganhTinhDiem = response.data
                this.isGetChuyenNganhTinhDiemLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isGetChuyenNganhTinhDiemLoading = false
            }
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

            this.isGetToChuc = false
        })
    }

    onSearchToChuc(event:any){
        if(event && event !== ""){
            this.isGetToChuc = true
            this.searchToChuc$.next(event)
        }
    }

    onGetSearchNoiHoc(){
        const listNoiHoc = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchNoiHoc$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listNoiHoc))

        optionList$.subscribe(data => {
            this.noiHocs = data.data

            this.isGetNoiHoc = false
        })
    }

    onSearchNoiHoc(event:any){
        if(event && event !== ""){
            this.isGetNoiHoc = true
            this.searchNoiHoc$.next(event)
        }
    }

    onSubmit(){
        const form = this.updateForm

        if(form.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng nhập đúng yêu cầu của form'
            )

            Object.values(form.controls).forEach(control => {
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({ onlySelf: true });
                }
            })

            return;
        }

        const data:UpdateUser = {
            name:form.get("name")?.value,
            // username:form.get("username")?.value,
            email:form.get("email")?.value,
            ngaysinh: form.get("ngaysinh")?.value !== null ? dateConvert(form.get("ngaysinh")?.value.toString()) : null,
            dienthoai: form.get("dienthoai")?.value ?? null,
            orchid: form.get("orchid")?.value ?? null,
            email2: form.get("email2")?.value ?? null,
            id_tochuc: form.get("id_tochuc")?.value ?? null,
            cohuu: form.get("cohuu")?.value ?? false,
            keodai: form.get("keodai")?.value ?? false,
            dinhmucnghiavunckh: form.get("dinhmucnghiavunckh")?.value ?? null,
            dangdihoc: form.get("dangdihoc")?.value ?? null,
            id_noihoc: form.get("dangdihoc")?.value !== null ? (form.get("id_noihoc")?.value ?? null) : null,
            id_ngachvienchuc: form.get("id_ngachvienchuc")?.value ?? null,
            id_quoctich:form.get("id_quoctich")?.value ?? null,
            id_hochamhocvi:form.get("id_hochamhocvi")?.value ?? null,
            id_chuyenmon:form.get("id_chuyenmon")?.value ?? null,
            id_nganhtinhdiem: form.get("id_nganhtinhdiem")?.value ?? null,
            id_chuyennganhtinhdiem: form.get("id_chuyennganhtinhdiem")?.value ?? null
        }

        this.isUpdate = true

        this.userService.updateUser(this.user.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isUpdate = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isUpdate = false
            }
        })
    }

    onChangePassword(){
        const form = this.formChangePassword

        if(form.invalid){
            this.notificationService.create(
                'error',
                "Lỗi",
                "Vui lòng nhập đúng yêu cầu của form"
            )

            Object.values(form.controls).forEach(control =>{
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({onlySelf:true})
                }
            })

            return;
        }

        const data:ChangePassword = form.value

        this.changePasswordLoading = true
        this.userService.changePassword(data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                form.reset()
                this.changePasswordLoading = false
            },
            error:(response) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    response
                )
                this.changePasswordLoading = false
            }
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}