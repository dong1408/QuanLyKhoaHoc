import {Component, OnDestroy, OnInit} from "@angular/core";
import {forkJoin, Subject, take, takeUntil} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {UserService} from "../../../core/services/user/user.service";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {HocHamHocViService} from "../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {DonVi} from "../../../core/types/user-info/don-vi.type";
import {DonViService} from "../../../core/services/user-info/don-vi.service";
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
import {RegisterUser, UpdateUser, UserDetail} from "../../../core/types/user/user.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
    selector:'app-user-update',
    styleUrls:['./update.component.css'],
    templateUrl:'./update.component.html'
})

export class UserUpdateComponent implements OnInit,OnDestroy{
    id:number

    destroy$ = new Subject<void>()

    isGetDonViLoading:boolean = false
    isGetChuyenNganhTinhDiemLoading:boolean = false
    isUpdate:boolean = false

    updateForm:FormGroup

    toChucs:ToChuc[] = []
    donVis:DonVi[] = []
    noiHocs:ToChuc[] = []
    ngachVienChucs:NgachVienChuc[] = []
    quocTichs:QuocGia[] = []
    hocHams:HocHamHocVi[] = []
    chuyenMons:ChuyenMon[] = []
    nganhTinhDiem:NganhTinhDiem[] = []
    chuyenNganhTinhDiem:ChuyenNganhTinhDiem[] = []
    roles:Role[] = []
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
        private roleService:RoleService,
        private _router: ActivatedRoute,
        private router:Router,
    ) {
    }

    ngOnInit() {

        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/nguoi-dung"])
                return;
            }
        })

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
            id_donvi:[
                null
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

        this.loadingService.startLoading()
        forkJoin([
            this.toChucService.getAllToChuc(),
            this.hocHamHocViService.getAllHocHamHocVi(),
            this.ngachVienChucService.getAllNgachVienChuc(),
            this.chuyenMonService.getAllChuyeMon(),
            this.quocGiaService.getAllQuocGia(),
            this.nganhTinhDiemService.getNganhTinhDiem(),
            this.donViService.getAllDonVi(),
            this.roleService.getAllRoles(),
            this.userService.getUserDetail(this.id),
            this.chuyenNganhTinhDiemService.getChuyenNganhTinhDiem()
        ],(tcResponse,hhResponse,nvcResponse,cmResponse,qgResponse,ntdResponse,dvResponse,rResponse,uResponse,cnResponse) => {
            return {
                listTC: tcResponse.data,
                listHH: hhResponse.data,
                listNVC: nvcResponse.data,
                listCM: cmResponse.data,
                listQG:qgResponse.data,
                listNTD:ntdResponse.data,
                listDV:dvResponse.data,
                listR:rResponse.data,
                user:uResponse.data,
                listCN:cnResponse.data,
            }
        }).subscribe({
            next:(response) =>{
                this.toChucs = response.listTC
                this.hocHams = response.listHH
                this.ngachVienChucs = response.listNVC
                this.chuyenMons = response.listCM
                this.quocTichs = response.listQG
                this.nganhTinhDiem = response.listNTD
                this.noiHocs = response.listTC
                this.roles = response.listR
                this.user = response.user
                this.donVis = response.listDV
                this.chuyenNganhTinhDiem = response.listCN

                this.updateForm.patchValue({
                    username: this.user.username,
                    name: this.user.name,
                    email:this.user.email,
                    ngaysinh:this.user.ngaysinh,
                    dienthoai:this.user.dienthoai,
                    email2:this.user.email2,
                    orchid:this.user.orchid,
                    id_tochuc:this.user.tochuc?.id,
                    id_donvi:this.user.donvi?.id,
                    cohuu:this.user.cohuu,
                    keodai:this.user.keodai,
                    dinhmucnghiavunckh:this.user.dinhmucnghiavunckh,
                    dangdihoc:this.user.dangdihoc,
                    id_noihoc:this.user.noihoc?.id,
                    id_ngachvienchuc: this.user.ngachvienchuc?.id,
                    id_quoctich: this.user.quoctich?.id,
                    id_hochamhocvi: this.user.hochamhocvi?.id,
                    id_chuyenmon: this.user.chuyenmon?.id,
                    id_nganhtinhdiem: this.user.nganhtinhdiem?.id,
                    id_chuyennganhtinhdiem: this.user.chuyennganhtinhdiem?.id
                })

                this.loadingService.stopLoading()
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.router.navigate(['/admin/nguoi-dung'])
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

    onSelectNganhTinhDiem(event:any){
        if(typeof(event) === 'number'){
            this.updateForm.controls?.['id_chuyennganhtinhdiem'].setValue(null)
            this.getChuyenNganhTinhDiem(event)
        }else{
            this.chuyenNganhTinhDiem = []
        }
        if(!this.updateForm.controls?.['id_nganhtinhdiem'].value){
            this.chuyenNganhTinhDiem = []
        }
    }

    onSelectToChuc(event:any){
        if(typeof(event) === 'number'){
            this.updateForm.controls?.['id_donvi'].setValue(null)
            this.getDonViByToChucId(event)
        }else{
            this.donVis = []
        }
        if(!this.updateForm.controls?.['id_donvi'].value){
            this.donVis = []
        }
    }

    onSelectNoHoc(event:any){
        if(typeof(event) !== null || typeof(event) !== undefined){
            this.updateForm.controls?.['id_noihoc'].enable()
        }else{
            this.updateForm.controls?.['id_noihoc'].disable()
        }

        if(!this.updateForm.controls?.['dangdihoc'].value){
            this.updateForm.controls?.['id_noihoc'].disable()
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
            id_donvi:form.get("id_tochuc")?.value ?? null,
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

        this.userService.updateUser(this.id,data)
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

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}