import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ActivatedRoute, Router} from "@angular/router";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {CapNhatSanPham} from "../../../core/types/sanpham/san-pham.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";
import {ChiTietDeTai} from "../../../core/types/detai/de-tai.type";
import {validValuesValidator} from "../../../shared/validators/valid-value.validator";
import {ApiResponse} from "../../../core/types/api-response.type";

@Component({
    selector:"app-detai-sanpham-capnhat",
    templateUrl:"./capnhat-sanpham.component.html",
    styleUrls:["./capnhat-sanpham.component.css"]
})

export class CapNhatSanPhamDeTaiComponent implements OnInit,OnDestroy{
    id:number
    detai:ChiTietDeTai

    dvTaiTros:ToChuc[] = []
    dvKhac:ToChuc[] = []

    isCapNhatLoading:boolean = false
    isGetTaiTro:boolean = false
    isGetDVKhac:boolean = false

    searchTaiTro$ = new BehaviorSubject('');
    searchDVKhac$ = new BehaviorSubject('');

    capNhatForm:FormGroup

    destroy$ = new Subject<void>()

    constructor(
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
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/de-tai"])
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
            solandaquydoi:[
                0,
                Validators.compose([
                ])
            ],
            cosudungemailtruong:[
                false,
            ],
            cosudungemaildonvikhac:[
                false,
            ],
            cothongtintruong:[
                false,
            ],
            cothongtindonvikhac:[
                false,
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
            diemquydoi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            gioquydoi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                ])
            ],
            thongtinchitiet:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                ])
            ],
            capsanpham:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    validValuesValidator(['Khoa','Cơ sở','Tỉnh','Bộ','Ngành','Nhà nước','Nước ngoài']),
                ])
            ],
            thoidiemcongbohoanthanh:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
            id_thongtinnoikhac:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            id_donvitaitro:[
                {
                    value:null,
                    disabled:true
                },
                Validators.compose([
                    Validators.required
                ])
            ],
            ngaykekhai:[
                null,
                Validators.compose([
                    Validators.required
                ])
            ],
        })
        this.capNhatForm.get("conhantaitro")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.capNhatForm.get("id_donvitaitro")?.enable()
                this.capNhatForm.get("chitietdonvitaitro")?.enable()
            }else{
                this.capNhatForm.get("chitietdonvitaitro")?.disable()
                this.capNhatForm.get("id_donvitaitro")?.disable()
                this.capNhatForm.get("chitietdonvitaitro")?.reset()
                this.capNhatForm.get("id_donvitaitro")?.reset()
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

        this.onGetSearchDVKhac()
        this.onGetSearchDVTaiTro()

        this.loadingService.startLoading()

        forkJoin([
                this.deTaiService.getChiTietDeTai(this.id),
            ],
            (dtResponse) => {
                return {
                    detai:dtResponse.data,
                }
            }
        ).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.detai = response.detai
                if(this.detai.sanpham.donvitaitro){
                    this.dvTaiTros = [...this.dvTaiTros,this.detai.sanpham.donvitaitro]
                }

                if(this.detai.sanpham.thongtinnoikhac){
                    this.dvKhac = [...this.dvKhac,this.detai.sanpham.thongtinnoikhac]
                }

                this.capNhatForm.patchValue({
                    tensanpham:this.detai.sanpham.tensanpham,
                    solandaquydoi:this.detai.sanpham.solandaquydoi ?? 0,
                    cosudungemailtruong:this.detai.sanpham.cosudungemailtruong ?? false,
                    cosudungemaildonvikhac:this.detai.sanpham.cosudungemaildonvikhac ?? false,
                    cothongtintruong:this.detai.sanpham.cothongtintruong ?? false,
                    cothongtindonvikhac:this.detai.sanpham.cothongtindonvikhac ?? false,
                    id_thongtinnoikhac:this.detai.sanpham.thongtinnoikhac?.id ?? null,
                    conhantaitro:this.detai.sanpham.conhantaitro ?? false,
                    id_donvitaitro:this.detai.sanpham.donvitaitro?.id ?? null,
                    chitietdonvitaitro:this.detai.sanpham.chitietdonvitaitro ?? null,
                    ngaykekhai:this.detai.sanpham.ngaykekhai,
                    diemquydoi:this.detai.sanpham.diemquydoi ?? null,
                    gioquydoi:this.detai.sanpham.gioquydoi ?? null,
                    thongtinchitiet:this.detai.sanpham.thongtinchitiet ?? null,
                    capsanpham:this.detai.sanpham.capsanpham ?? null,
                    thoidiemcongbohoanthanh:this.detai.sanpham.thoidiemcongbohoanthanh
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
                this.router.navigate(['/admin/de-tai'])
                return;
            }
        })
    }

    onGetSearchDVKhac(){
        const listDVKhac = (keyword:string):Observable<ApiResponse<ToChuc[]>> =>  this.toChucService.getAllToChuc(keyword)
        const optionList$:Observable<ApiResponse<ToChuc[]>> = this.searchDVKhac$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listDVKhac))

        optionList$.subscribe(data => {
            this.dvKhac = data.data
            this.isGetDVKhac = false
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
            this.isGetTaiTro = false
        })
    }

    onSearchTaiTro(event:any){
        if(event && event !== ""){
            this.isGetTaiTro = true
            this.searchTaiTro$.next(event)
        }
    }

    onSearchDVKhac(event:any){
        if(event && event !== ""){
            this.isGetDVKhac = true
            this.searchDVKhac$.next(event)
        }
    }

    onCapNhatDeTaiSanPham(){
        const form = this.capNhatForm
        if(form.invalid){
            this.notificationService.create(
                'error',
                "Lỗi",
                "Vui lòng điền đúng yêu cầu của form"
            )
            Object.values(form.controls).forEach(control =>{
                if(control.invalid){
                    control.markAsDirty()
                    control.updateValueAndValidity({ onlySelf: true });
                }
            })

            return;
        }

        const data:CapNhatSanPham = {
            ...form.value,
            thoidiemcongbohoanthanh: dateConvert(form.get('thoidiemcongbohoanthanh')?.value),
            ngaykekhai: dateConvert(form.get('ngaykekhai')?.value)
        }

        this.isCapNhatLoading = true
        this.deTaiService.capNhatSanPham(this.id,data)
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
                console.log(error)
                this.isCapNhatLoading = false
                return;
            }
        })
    }

    // compareFn = (o1: any, o2: any) => (o1 && o2 ? o1.id === o2.id : o1 === o2);

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }
}