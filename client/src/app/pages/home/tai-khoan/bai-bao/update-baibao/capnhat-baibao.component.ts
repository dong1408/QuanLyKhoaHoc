import {Component, OnDestroy, OnInit} from "@angular/core";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {ActivatedRoute, Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CapNhatBaiBao, CapNhatBaiBaoUser, ChiTietBaiBao} from "../../../../../core/types/baibao/bai-bao.type";
import {KeKhaiTapChi, Magazine} from "../../../../../core/types/tapchi/tap-chi.type";
import {TapChiService} from "../../../../../core/services/tapchi/tap-chi.service";
import {LoadingService} from "../../../../../core/services/loading.service";
import {BaiBaoService} from "../../../../../core/services/baibao/bai-bao.service";
import {noWhiteSpaceValidator} from "../../../../../shared/validators/no-white-space.validator";
import {dateConvert} from "../../../../../shared/commons/utilities";
import {KeKhaiToChuc, ToChuc} from "../../../../../core/types/user-info/to-chuc.type";
import {VaiTroTacGia} from "../../../../../core/types/sanpham/vai-tro-tac-gia.type";
import {User} from "../../../../../core/types/user/user.type";
import {KeKhaiKeyword, Keyword} from "../../../../../core/types/baibao/keyword.type";
import {HocHamHocVi} from "../../../../../core/types/user-info/hoc-ham-hoc-vi.type";
import {ToChucService} from "../../../../../core/services/user-info/to-chuc.service";
import {UserService} from "../../../../../core/services/user/user.service";
import {PagingService} from "../../../../../core/services/paging.service";
import {VaiTroService} from "../../../../../core/services/sanpham/vai-tro.service";
import {KeywordService} from "../../../../../core/services/baibao/keyword.service";
import {HocHamHocViService} from "../../../../../core/services/user-info/hoc-ham-hoc-vi.service";
import {ConstantsService} from "../../../../../core/services/constants.service";
import {ApiResponse} from "../../../../../core/types/api-response.type";
import {CapNhatSanPhamUser} from "../../../../../core/types/sanpham/san-pham.type";

@Component({
    selector:"app-taikhoan-baibao-capnhat",
    templateUrl:"./capnhat-baibao.component.html",
    styleUrls:["./capnhat-baibao.component.css"]
})

export class CapNhatBaiBaoComponent implements OnInit,OnDestroy{
    id:number
    keKhaiToChuc:any = []
    keKhaiKeyword:any = []
    keKhaiTapChi:any = []

    baibao:ChiTietBaiBao

    tochucs:ToChuc[] = []
    tapChis:Magazine[] = []
    vaiTros:VaiTroTacGia[] = []
    users:User[] = []
    keywords:Keyword[] = []
    dvTaiTros:ToChuc[] = []
    hhhvs:HocHamHocVi[] = []

    capNhatForm:FormGroup
    tochucForm:FormGroup
    keywordForm:FormGroup
    tapchiForm:FormGroup

    isCapNhatLoading:boolean = false
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
        private vaiTroService:VaiTroService,
        private baiBaoService:BaiBaoService,
        private keywordService:KeywordService,
        private hhhvService:HocHamHocViService,
        private _router:ActivatedRoute,
        private router:Router,
        private AppConstant:ConstantsService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/home/tai-khoan/san-pham/bai-bao"])
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

        this.capNhatForm.get("cothongtindonvikhac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("id_thongtinnoikhac")?.enable()
            }else{
                this.capNhatForm.get("id_thongtinnoikhac")?.disable()
                this.capNhatForm.get("id_thongtinnoikhac")?.reset()
            }
        })

        this.onGetSearchDVTaiTro()
        this.onGetSearchKeyword()
        this.onGetSearchTapChi()
        this.onGetSearchToChuc()
        this.loadingService.startLoading()

        forkJoin([
            this.baiBaoService.getChiTietBaiBao(this.id),
            this.vaiTroService.getVaiTroBaiBao(),
            this.hhhvService.getAllHocHamHocVi()
        ],
            (bbResponse,vtResponse,hhResponse) => {
                return {
                    baibao:bbResponse.data,
                    listVT: vtResponse.data,
                    listhh: hhResponse.data
                }
            }
        ).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao = response.baibao
                if(this.baibao.sanpham.trangthairasoat === this.AppConstant.TT_DA_XAC_NHAN){
                    this.notificationService.create(
                        'error',
                        'Lỗi',
                        'Bài báo đã được rà soát, không được phép cập nhật nữa.'
                    )
                    this.router.navigate(["/home/tai-khoan/san-pham/bai-bao",this.id])
                    this.loadingService.stopLoading()
                    return
                }
                this.tapChis = [...this.tapChis,this.baibao.tapchi]
                if(this.baibao.keywords !== null){
                    this.keywords = [...this.keywords,...this.baibao.keywords]
                }

                if(this.baibao.sanpham.donvitaitro){
                    this.dvTaiTros = [...this.dvTaiTros,this.baibao.sanpham.donvitaitro]
                }

                this.capNhatForm.patchValue({
                    doi:this.baibao.doi ?? null,
                    url:this.baibao.url ?? null,
                    received:this.baibao.received ?? null,
                    accepted:this.baibao.accepted ?? null,
                    published:this.baibao.published ?? null,
                    abstract:this.baibao.abstract ?? null,
                    keywords:this.baibao.keywords ?? null,
                    volume:this.baibao.volume ?? null,
                    issue:this.baibao.issue ?? null,
                    number:this.baibao.number ?? null,
                    pages:this.baibao.number ?? null,
                    conhantaitro:this.baibao.sanpham.conhantaitro ?? false,
                    id_tapchi:this.baibao.tapchi,
                    tensanpham:this.baibao.sanpham.tensanpham,
                    donvi:this.baibao.sanpham.donvitaitro ?? null,
                    chitietdonvitaitro:this.baibao.sanpham.chitietdonvitaitro ?? null,
                    ngaykekhai:this.baibao.sanpham.ngaykekhai,
                    thoidiemcongbohoanthanh:this.baibao.sanpham.thoidiemcongbohoanthanh
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
                this.router.navigate(['/home/tai-khoan/san-pham/bai-bao'])
                return;
            }
        })
    }

    onXoaToChucKeKhai(tentochuc:string){
        this.keKhaiToChuc = this.keKhaiToChuc.filter((item:KeKhaiToChuc) => item.tentochuc !== tentochuc)
        this.capNhatForm.get("donvi")?.reset()
        this.dvTaiTros = this.dvTaiTros.filter((item:ToChuc) => item.tentochuc !== tentochuc)
    }

    onXoaTapChiKeKhai(tentapchi:string){
        this.keKhaiTapChi = this.keKhaiTapChi.filter((item:KeKhaiTapChi) => item.name !== tentapchi)
        this.capNhatForm.get("tapchi")?.reset()
        this.tapChis = this.tapChis.filter((item:Magazine) => item.name !== tentapchi)
    }

    onXoaKeyword(name:string){
        this.keKhaiKeyword = this.keKhaiKeyword.filter((item:KeKhaiKeyword) => item.name !== name)
        this.capNhatForm.get("keywords")?.reset()
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

    onCapNhatBaiBao(){
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

        const data:CapNhatBaiBaoUser = {
            sanpham:{
                tensanpham: form.get('tensanpham')?.value,
                thoidiemcongbohoanthanh:  dateConvert(form.get('thoidiemcongbohoanthanh')?.value.toString())!!,
                conhantaitro : form.get('conhantaitro')?.value ?? false,
                donvi :form.get('conhantaitro')?.value === true ? {
                    id_donvi: form.get('donvi')?.value['id'] ?? null,
                    tentochuc: form.get('donvi')?.value['tentochuc']
                } : null,
                chitietdonvitaitro: form.get('conhantaitro')?.value === true ? form.get('chitietdonvitaitro')?.value : null
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
            volume:form.get('volume')?.value ?? null,
            issue:form.get('issue')?.value ?? null,
            number:form.get('number')?.value ?? null,
            pages:form.get('pages')?.value ?? null,
        }

        this.isCapNhatLoading = true
        this.baiBaoService.capNhatBaiBaoChoNguoiDung(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) => {
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.isCapNhatLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    "Cập nhật thất bại, vui lòng thử lại sau"
                )
                this.isCapNhatLoading = false
                return;
            }
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}