import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";
import {ActivatedRoute, Router} from "@angular/router";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../shared/validators/valid-value.validator";
import {PhanLoaiDeTai} from "../../../core/types/detai/phan-loai-de-tai.type";
import {PhanLoaiDeTaiService} from "../../../core/services/detai/phan-loai-de-tai.service";
import {CapNhatDeTai, ChiTietDeTai} from "../../../core/types/detai/de-tai.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {ApiResponse} from "../../../core/types/api-response.type";

@Component({
    selector:'app-detai-capnhat',
    templateUrl:'./capnhat-detai.component.html',
    styleUrls:['./capnhat-detai.component.css']
})

export class CapNhatDeTaiComponent implements OnInit,OnDestroy{
    id:number
    detai:ChiTietDeTai
    tcHopTac:ToChuc[] = []
    tcChuQuan:ToChuc[]= []
    phanLoais:PhanLoaiDeTai[] = []

    isCapNhatLoading:boolean = false
    isGetChuQuan:boolean = false
    isGetHopTac:boolean = false

    capNhatForm:FormGroup

    searchChuQuan$ = new BehaviorSubject('');
    searchHopTac$ = new BehaviorSubject('');

    destroy$ = new Subject<void>()

    constructor(
        private phanLoaiDeTaiService:PhanLoaiDeTaiService,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private deTaiService:DeTaiService,
        private _router: ActivatedRoute,
        private router:Router,
        private fb:FormBuilder,
        private toChucService:ToChucService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if (parseInt(params.get("id") as string)) {
                this.id = parseInt(params.get("id") as string)
            } else {
                this.router.navigate(["/admin/de-tai"])
                return;
            }
        })

        this.capNhatForm = this.fb.group({
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
            id_tochucchuquan:[
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
            id_tochuchoptac:[
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
            ngaydangky:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ]
        })

        this.capNhatForm.get("detaihoptac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("id_tochuchoptac")?.enable()
                this.capNhatForm.get("tylekinhphidonvihoptac")?.enable()
            }else{
                this.capNhatForm.get("id_tochuchoptac")?.disable()
                this.capNhatForm.get("tylekinhphidonvihoptac")?.disable()
                this.capNhatForm.get("id_tochuchoptac")?.reset()
                this.capNhatForm.get("tylekinhphidonvihoptac")?.reset()
            }
        })

        this.capNhatForm.get("ngoaitruong")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("truongchutri")?.enable()
                this.capNhatForm.get("id_tochucchuquan")?.enable()

                this.capNhatForm.get("id_loaidetai")?.disable()
                this.capNhatForm.get("id_loaidetai")?.reset()
            }else{
                this.capNhatForm.get("truongchutri")?.disable()
                this.capNhatForm.get("id_tochucchuquan")?.disable()
                this.capNhatForm.get("id_tochucchuquan")?.reset()
                this.capNhatForm.get("truongchutri")?.reset()

                this.capNhatForm.get("id_loaidetai")?.enable()
            }
        })

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

                if(this.detai.tochucchuquan){
                    this.tcChuQuan = [...this.tcChuQuan,this.detai.tochucchuquan]
                }
                if(this.detai.tochuchoptac){
                    this.tcHopTac = [...this.tcHopTac,this.detai.tochuchoptac]
                }

                this.capNhatForm.patchValue({
                    maso: this.detai.maso,
                    ngoaitruong: this.detai.ngoaitruong ?? false,
                    truongchutri: this.detai.truongchutri ?? false,
                    id_tochucchuquan:this.detai.tochucchuquan ? this.detai.tochucchuquan.id : null,
                    id_loaidetai: this.detai.loaidetai ? this.detai.loaidetai.id : null,
                    detaihoptac: this.detai.detaihoptac ?? false,
                    id_tochuchoptac: this.detai.tochuchoptac ? this.detai.tochuchoptac.id : null,
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
                this.router.navigate(["/admin/de-tai"])
                return
            }
        })
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

        const data:CapNhatDeTai = {
            maso:form.get('maso')?.value,
            ngoaitruong:form.get('ngoaitruong')?.value ?? false,
            truongchutri: form.get('ngoaitruong')?.value === true ? form.get('truongchutri')?.value : null,
            id_tochucchuquan : form.get('ngoaitruong')?.value === true ? form.get('id_tochucchuquan')?.value : null,
            id_loaidetai: form.get('ngoaitruong')?.value === false ? form.get('id_loaidetai')?.value : null,
            detaihoptac: form.get('detaihoptac')?.value ?? false,
            id_tochuchoptac: form.get('detaihoptac')?.value === true ? form.get('id_tochuchoptac')?.value : null,
            tylekinhphidonvihoptac: form.get('detaihoptac')?.value === true ? form.get('tylekinhphidonvihoptac')?.value : null,
            capdetai: form.get('capdetai')?.value ?? null,
            ngaydangky: form.get('ngaydangky')?.value !== null ? dateConvert(form.get('ngaydangky')?.value.toString()) : null
        }

        this.isCapNhatLoading = true
        this.deTaiService.capNhatDeTai(this.id,data)
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

    onGetSearchToChucChuQuan(){
        const listDVChuQuan = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchChuQuan$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listDVChuQuan))

        optionList$.subscribe(data => {
            this.tcChuQuan = data.data
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
            this.isGetHopTac = false
        })
    }

    onSearchToChucHopTac(event:any){
        if(event && event !== ""){
            this.isGetHopTac = true
            this.searchHopTac$.next(event)
        }
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}