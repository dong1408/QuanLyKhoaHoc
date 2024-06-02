import {Component, OnDestroy, OnInit} from "@angular/core";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, take, takeUntil} from "rxjs"
import {NzNotificationService} from "ng-zorro-antd/notification";
import {UserService} from "../../../core/services/user/user.service";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {HocHamHocViService} from "../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {NganhTinhDiemService} from "../../../core/services/quydoi/nganh-tinh-diem.service";
import {ChuyenNganhTinhDiemService} from "../../../core/services/quydoi/chuyen-nganh-tinh-diem.service";
import {ChuyenMonService} from "../../../core/services/user-info/chuyen-mon.service";
import {QuocGiaService} from "../../../core/services/user-info/quoc-gia.service";
import {NgachVienChucService} from "../../../core/services/user-info/ngach-vien-chuc.service";
import {LoadingService} from "../../../core/services/loading.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../shared/validators/valid-value.validator";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {NgachVienChuc} from "../../../core/types/user-info/ngach-vien-chuc.type";
import {QuocGia} from "../../../core/types/user-info/quoc-gia.type";
import {HocHamHocVi} from "../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {ChuyenMon} from "../../../core/types/user-info/chuyen-mon.type";
import {NganhTinhDiem} from "../../../core/types/quydoi/nganh-tinh-diem.type";
import {ChuyenNganhTinhDiem} from "../../../core/types/quydoi/chuyen-nganh-tinh-diem.type";
import {RoleService} from "../../../core/services/roles/role.service";
import {Role} from "../../../core/types/roles/role.type";
import {RegisterUser} from "../../../core/types/user/user.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {Router} from "@angular/router";
import {ApiResponse} from "../../../core/types/api-response.type";

@Component({
    selector:'app-user-create',
    styleUrls:['./create.component.css'],
    templateUrl:'./create.component.html'
})

export class UserCreateComponent implements OnInit,OnDestroy{
    destroy$ = new Subject<void>()

    isGetChuyenNganhTinhDiemLoading:boolean = false
    isCreate:boolean = false

    createForm:FormGroup

    isGetToChuc: boolean = false
    isGetNoiHoc: boolean = false

    searchToChuc$ = new BehaviorSubject('');
    searchNoiHoc$ = new BehaviorSubject('');

    tochucs:ToChuc[] = []
    noiHocs:ToChuc[] = []
    ngachVienChucs:NgachVienChuc[] = []
    quocTichs:QuocGia[] = []
    hocHams:HocHamHocVi[] = []
    chuyenMons:ChuyenMon[] = []
    nganhTinhDiem:NganhTinhDiem[] = []
    chuyenNganhTinhDiem:ChuyenNganhTinhDiem[] = []
    roles:Role[] = []

    constructor(
        private fb:FormBuilder,
        private notificationService:NzNotificationService,
        private userService:UserService,
        private toChucService:ToChucService,
        private hocHamHocViService:HocHamHocViService,
        private nganhTinhDiemService:NganhTinhDiemService,
        private chuyenNganhTinhDiemService:ChuyenNganhTinhDiemService,
        private chuyenMonService:ChuyenMonService,
        private quocGiaService:QuocGiaService,
        private ngachVienChucService:NgachVienChucService,
        public loadingService:LoadingService,
        private roleService:RoleService,
        private router:Router
    ) {
    }

    ngOnInit() {

        this.createForm = this.fb.group({
            name:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            username:[
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
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
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
            ],
            roles_id:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ]
        })

        this.createForm.get("dangdihoc")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select !== null){
                this.createForm.get("id_noihoc")?.enable()
            }else{
                this.createForm.get("id_noihoc")?.disable()
                this.createForm.get("id_noihoc")?.reset()
            }
        })

        this.createForm.get("id_nganhtinhdiem")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select !== null){
                this.createForm.get("id_chuyennganhtinhdiem")?.reset()
                this.getChuyenNganhTinhDiem(select)
                this.createForm.get("id_chuyennganhtinhdiem")?.enable()
            }else{
                this.createForm.get("id_chuyennganhtinhdiem")?.disable()
                this.createForm.get("id_chuyennganhtinhdiem")?.reset()
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
            this.roleService.getAllRoles()
        ],(hhResponse,nvcResponse,cmResponse,qgResponse,ntdResponse,rResponse) => {
            return {
                listHH: hhResponse.data,
                listNVC: nvcResponse.data,
                listCM: cmResponse.data,
                listQG:qgResponse.data,
                listNTD:ntdResponse.data,
                listR:rResponse.data
            }
        }).subscribe({
            next:(response) =>{
                this.hocHams = response.listHH
                this.ngachVienChucs = response.listNVC
                this.chuyenMons = response.listCM
                this.quocTichs = response.listQG
                this.nganhTinhDiem = response.listNTD
                this.roles = response.listR

                this.loadingService.stopLoading()
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.loadingService.stopLoading()
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
        const form = this.createForm

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

        const data:RegisterUser = {
            name:form.get("name")?.value,
            username:form.get("username")?.value,
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
            id_noihoc: form.get("id_noihoc")?.value ?? null,
            id_ngachvienchuc: form.get("id_ngachvienchuc")?.value ?? null,
            id_quoctich:form.get("id_quoctich")?.value ?? null,
            id_hochamhocvi:form.get("id_hochamhocvi")?.value ?? null,
            id_chuyenmon:form.get("id_chuyenmon")?.value ?? null,
            id_nganhtinhdiem: form.get("id_nganhtinhdiem")?.value ?? null,
            id_chuyennganhtinhdiem: form.get("id_chuyennganhtinhdiem")?.value ?? null,
            roles_id:form.get("roles_id")?.value
        }

        this.isCreate = true

        this.userService.registerUser(data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )

                this.createForm.reset()
                this.isCreate = false
                this.router.navigate(["/admin/nguoi-dung"])
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )

                this.isCreate = false
            }
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}