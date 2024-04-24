import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {CapNhatDeTai, CapNhatDeTaiUser, ChiTietDeTai} from "../../../../../core/types/detai/de-tai.type";
import {KeKhaiToChuc, ToChuc} from "../../../../../core/types/user-info/to-chuc.type";
import {PhanLoaiDeTai} from "../../../../../core/types/detai/phan-loai-de-tai.type";
import {PhanLoaiDeTaiService} from "../../../../../core/services/detai/phan-loai-de-tai.service";
import {LoadingService} from "../../../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {DeTaiService} from "../../../../../core/services/detai/de-tai.service";
import {ActivatedRoute, Router} from "@angular/router";
import {ToChucService} from "../../../../../core/services/user-info/to-chuc.service";
import {noWhiteSpaceValidator} from "../../../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../../../shared/validators/valid-value.validator";
import {dateConvert} from "../../../../../shared/commons/utilities";
import {ApiResponse} from "../../../../../core/types/api-response.type";
import {ConstantsService} from "../../../../../core/services/constants.service";

@Component({
    selector:'app-taikhoan-detai-capnhat',
    templateUrl:'./capnhat-detai.component.html',
    styleUrls:['./capnhat-detai.component.css']
})

export class CapNhatDeTaiComponent implements OnInit,OnDestroy{
    id:number
    detai:ChiTietDeTai
    phanLoais:PhanLoaiDeTai[]

    dvTaiTros:ToChuc[] = []
    tcChuQuan:ToChuc[]= []
    tcHopTac:ToChuc[]= []
    tochucs:ToChuc[]= []

    keKhaiToChuc:any = []

    isCapNhatLoading:boolean = false
    isGetTaiTro:boolean = false
    isGetChuQuan:boolean = false
    isGetHopTac:boolean = false
    isGetToChuc: boolean = false

    isOpenListToChucKeKhai:boolean = false

    isOpenFormToChuc:boolean = false

    capNhatForm:FormGroup
    tochucForm:FormGroup

    destroy$ = new Subject<void>()

    searchTaiTro$ = new BehaviorSubject('');
    searchChuQuan$ = new BehaviorSubject('');
    searchHopTac$ = new BehaviorSubject('');
    searchToChuc$ = new BehaviorSubject('');

    constructor(
        private phanLoaiDeTaiService:PhanLoaiDeTaiService,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private deTaiService:DeTaiService,
        private _router: ActivatedRoute,
        private router:Router,
        private fb:FormBuilder,
        private toChucService:ToChucService,
        public AppConstant:ConstantsService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if (parseInt(params.get("id") as string)) {
                this.id = parseInt(params.get("id") as string)
            } else {
                this.router.navigate(["/home/tai-khoan/san-pham/de-tai"])
                return;
            }
        })

        this.capNhatForm = this.fb.group({
            tensanpham:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            conhantaitro:[
                false,
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

        this.capNhatForm.get("conhantaitro")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("donvi")?.enable()
                this.capNhatForm.get("chitietdonvitaitro")?.enable()
            }else{
                this.capNhatForm.get("chitietdonvitaitro")?.disable()
                this.capNhatForm.get("donvi")?.disable()
                this.capNhatForm.get("chitietdonvitaitro")?.reset()
                this.capNhatForm.get("donvi")?.reset()
            }
        })

        this.capNhatForm.get("detaihoptac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("tochuchoptac")?.enable()
                this.capNhatForm.get("tylekinhphidonvihoptac")?.enable()
            }else{
                this.capNhatForm.get("tochuchoptac")?.disable()
                this.capNhatForm.get("tylekinhphidonvihoptac")?.disable()
                this.capNhatForm.get("tochuchoptac")?.reset()
                this.capNhatForm.get("tylekinhphidonvihoptac")?.reset()
            }
        })

        this.capNhatForm.get("ngoaitruong")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("truongchutri")?.enable()
                this.capNhatForm.get("tochucchuquan")?.enable()

                this.capNhatForm.get("id_loaidetai")?.disable()
                this.capNhatForm.get("id_loaidetai")?.reset()
            }else{
                this.capNhatForm.get("truongchutri")?.disable()
                this.capNhatForm.get("tochucchuquan")?.disable()
                this.capNhatForm.get("tochucchuquan")?.reset()
                this.capNhatForm.get("truongchutri")?.reset()

                this.capNhatForm.get("id_loaidetai")?.enable()
            }
        })

        this.onGetSearchDVTaiTro()
        this.onGetSearchToChuc()
        this.onGetSearchToChucHopTac()
        this.onGetSearchToChucChuQuan()

        this.loadingService.startLoading()
        forkJoin([
            this.phanLoaiDeTaiService.getPhanLoaiDeTai(),
            this.deTaiService.getChiTietDeTai(this.id)
        ],(plResponse,dtResponse) => {
            return {
                listPL: plResponse.data,
                detai:dtResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.phanLoais = response.listPL
                this.detai = response.detai

                if(this.detai.trangthairasoat === this.AppConstant.TT_DA_XAC_NHAN){
                    this.notificationService.create(
                        'error',
                        'Lỗi',
                        'Đề tài đã được rà soát, không được phép cập nhật nữa.'
                    )
                    this.router.navigate(["/home/tai-khoan/san-pham/de-tai",this.id])
                    this.loadingService.stopLoading()
                    return
                }

                if(this.detai.tochucchuquan){
                    this.tcChuQuan = [...this.tcChuQuan,this.detai.tochucchuquan]
                }
                if(this.detai.tochuchoptac){
                    this.tcHopTac = [...this.tcHopTac,this.detai.tochuchoptac]
                }

                if(this.detai.sanpham.donvitaitro){
                    this.dvTaiTros = [...this.dvTaiTros,this.detai.sanpham.donvitaitro]
                }

                this.capNhatForm.patchValue({
                    tensanpham:this.detai.sanpham.tensanpham,
                    conhantaitro:this.detai.sanpham.conhantaitro ?? false,
                    donvi:this.detai.sanpham.donvitaitro ? this.detai.sanpham.donvitaitro : null,
                    chitietdonvitaitro:this.detai.sanpham.chitietdonvitaitro ?? null,
                    maso: this.detai.maso,
                    ngoaitruong: this.detai.ngoaitruong ?? false,
                    truongchutri: this.detai.truongchutri ?? false,
                    tochucchuquan:this.detai.tochucchuquan ? this.detai.tochucchuquan : null,
                    id_loaidetai: this.detai.loaidetai ? this.detai.loaidetai.id : null,
                    detaihoptac: this.detai.detaihoptac ?? false,
                    tochuchoptac: this.detai.tochuchoptac ? this.detai.tochuchoptac : null,
                    tylekinhphidonvihoptac: this.detai.tylekinhphidonvihoptac ?? null,
                    capdetai: this.detai.capdetai ?? null,
                    ngaydangky: this.detai.ngaydangky ?? null
                })

                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Có lỗi xảy ra, vui lòng thử lại sau'
                )

                this.loadingService.stopLoading()
                this.router.navigate(["/home/tai-khoan/san-pham/de-tai"])
                return
            }
        })
    }

    onOpenListToChucKeKhai(){
        this.isOpenListToChucKeKhai = !this.isOpenListToChucKeKhai
    }
    onXoaToChucKeKhai(tentochuc:string){
        this.keKhaiToChuc = this.keKhaiToChuc.filter((item:KeKhaiToChuc) => item.tentochuc !== tentochuc)
        this.capNhatForm.get("tochucchuquan")?.reset()
        this.capNhatForm.get("donvi")?.reset()
        this.capNhatForm.get("tochuchoptac")?.reset()
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

    onSubmit(){
        const form = this.capNhatForm
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

        const data:CapNhatDeTaiUser = {
            sanpham:{
                tensanpham: form.get('tensanpham')?.value,
                conhantaitro : form.get('conhantaitro')?.value ?? false,
                donvi :form.get('conhantaitro')?.value === true ? {
                    id_donvi: form.get('donvi')?.value['id'] ?? null,
                    tentochuc: form.get('donvi')?.value['tentochuc']
                } : null,
                chitietdonvitaitro: form.get('conhantaitro')?.value === true ? form.get('chitietdonvitaitro')?.value : null
            },
            maso:form.get('maso')?.value,
            ngoaitruong:form.get('ngoaitruong')?.value ?? false,
            truongchutri: form.get('ngoaitruong')?.value === true ? form.get('truongchutri')?.value : null,
            id_loaidetai: form.get('ngoaitruong')?.value === false ? form.get('id_loaidetai')?.value : null,
            detaihoptac: form.get('detaihoptac')?.value ?? false,
            tylekinhphidonvihoptac: form.get('detaihoptac')?.value === true ? form.get('tylekinhphidonvihoptac')?.value : null,
            capdetai: form.get('capdetai')?.value ?? null,
            tochucchuquan : form.get('ngoaitruong')?.value === true ? {
                id_tochucchuquan:form.get('tochucchuquan')?.value['id'] ?? null,
                tentochuc: form.get('tochucchuquan')?.value['tentochuc'],
            } : null,
            tochuchoptac: form.get('detaihoptac')?.value === true ? {
                id_tochuchoptac:form.get('tochuchoptac')?.value['id'] ?? null,
                tentochuc: form.get('tochuchoptac')?.value['tentochuc'],
            } : null,
        }

        this.isCapNhatLoading = true
        this.deTaiService.capNhatDeTaiChoNguoiDung(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.isCapNhatLoading = false
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isCapNhatLoading = false
            }
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}