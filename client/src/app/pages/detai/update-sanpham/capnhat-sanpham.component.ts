import {Component, OnDestroy, OnInit} from "@angular/core";
import {CapNhatBaiBao, ChiTietBaiBao} from "../../../core/types/baibao/bai-bao.type";
import {Magazine} from "../../../core/types/tapchi/tap-chi.type";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {forkJoin, Subject, takeUntil} from "rxjs";
import {BaiBaoService} from "../../../core/services/baibao/bai-bao.service";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {ActivatedRoute, Router} from "@angular/router";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {CapNhatSanPham} from "../../../core/types/sanpham/san-pham.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {DeTaiService} from "../../../core/services/detai/de-tai.service";
import {ChiTietDeTai} from "../../../core/types/detai/de-tai.type";

@Component({
    selector:"app-detai-sanpham-capnhat",
    templateUrl:"./capnhat-sanpham.component.html",
    styleUrls:["./capnhat-sanpham.component.css"]
})

export class CapNhatSanPhamDeTaiComponent implements OnInit,OnDestroy{
    id:number
    detai:ChiTietDeTai
    tochucs:ToChuc[]

    isCapNhatLoading:boolean = false

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
            ngaykekhai:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
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
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            solandaquydoi:[
                0,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            cosudungemailtruong:[
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            cosudungemaildonvikhac:[
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            cothongtintruong:[
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            cothongtindonvikhac:[
                false,
                Validators.compose([
                    noWhiteSpaceValidator
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
            diemquydoi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.required
                ])
            ],
            gioquydoi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.required
                ])
            ],
            thongtinchitiet:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.required
                ])
            ],
            capsanpham:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.required
                ])
            ],
            thoidiemcongbohoanthanh:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
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

        this.loadingService.startLoading()

        forkJoin([
                this.deTaiService.getChiTietDeTai(this.id),
                this.toChucService.getAllToChuc()
            ],
            (dtResponse,tcResponse) => {
                return {
                    detai:dtResponse.data,
                    tochucs:tcResponse.data
                }
            }
        ).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.detai = response.detai
                this.tochucs = response.tochucs

                this.capNhatForm.patchValue({
                    tensanpham:this.detai.sanpham.tensanpham,
                    tongsotacgia:this.detai.sanpham.tongsotacgia,
                    solandaquydoi:this.detai.sanpham.solandaquydoi,
                    cosudungemailtruong:this.detai.sanpham.cosudungemailtruong ?? false,
                    cosudungemaildonvikhac:this.detai.sanpham.cosudungemaildonvikhac ?? false,
                    cothongtintruong:this.detai.sanpham.cothongtintruong ?? false,
                    cothongtindonvikhac:this.detai.sanpham.cothongtindonvikhac ?? false,
                    id_thongtinnoikhac:this.detai.sanpham.thongtinnoikhac?.id ?? null,
                    conhantaitro:this.detai.sanpham.conhantaitro ?? false,
                    id_donvitaitro:this.detai.sanpham.donvitaitro?.id ?? null,
                    chitietdonvitaitro:this.detai.sanpham.chitietdonvitaitro ?? null,
                    ngaykekhai:this.detai.sanpham.ngaykekhai,
                    diemquydoi:this.detai.sanpham.diemquydoi,
                    gioquydoi:this.detai.sanpham.gioquydoi,
                    thongtinchitiet:this.detai.sanpham.thongtinchitiet,
                    capsanpham:this.detai.sanpham.capsanpham,
                    thoidiemcongbohoanthanh:this.detai.sanpham.thoidiemcongbohoanthanh
                })
                // console.log(response.detai)
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