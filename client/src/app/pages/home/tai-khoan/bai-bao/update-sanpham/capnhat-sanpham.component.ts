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

@Component({
    selector:"app-baibao-sanpham-capnhat",
    templateUrl:"./capnhat-sanpham.component.html",
    styleUrls:["./capnhat-sanpham.component.css"]
})

export class CapNhatSanPhamBaiBaoComponent implements OnInit,OnDestroy{
    id:number
    baibao:ChiTietBaiBao
    tochucs:ToChuc[]

    isCapNhatLoading:boolean = false

    capNhatForm:FormGroup

    destroy$ = new Subject<void>()

    constructor(
        private baiBaoService:BaiBaoService,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private tapChiService:TapChiService,
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
                this.router.navigate(["/bai-bao"])
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
            ngaykekhai:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
        })
        this.capNhatForm.get("conhantaitro")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            console.log("conhantaitro")
            if(select === true){
                this.capNhatForm.get("id_donvitaitro")?.enable()
                this.capNhatForm.get("chitietdonvitaitro")?.enable()
            }else{
                this.capNhatForm.get("chitietdonvitaitro")?.disable()
                this.capNhatForm.get("id_donvitaitro")?.disable()
                // this.capNhatForm.get("chitietdonvitaitro")?.reset()
                // this.capNhatForm.get("id_donvitaitro")?.reset()
            }
        })

        this.capNhatForm.get("cothongtindonvikhac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            console.log("cothongtindonvikhac")
            if(select === true){
                this.capNhatForm.get("id_thongtinnoikhac")?.enable()
            }else{
                this.capNhatForm.get("id_thongtinnoikhac")?.disable()
                // this.capNhatForm.get("id_thongtinnoikhac")?.reset()
            }
        })

        this.loadingService.startLoading()

        forkJoin([
                this.baiBaoService.getChiTietBaiBao(this.id),
                this.toChucService.getAllToChuc()
            ],
            (bbResponse,tcResponse) => {
                return {
                    baibao:bbResponse.data,
                    tochucs:tcResponse.data
                }
            }
        ).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao = response.baibao
                this.tochucs = response.tochucs

                this.capNhatForm.patchValue({
                    tensanpham:this.baibao.sanpham.tensanpham,
                    tongsotacgia:this.baibao.sanpham.tongsotacgia,
                    solandaquydoi:this.baibao.sanpham.solandaquydoi,
                    cosudungemailtruong:this.baibao.sanpham.cosudungemailtruong ?? false,
                    cosudungemaildonvikhac:this.baibao.sanpham.cosudungemaildonvikhac ?? false,
                    cothongtintruong:this.baibao.sanpham.cothongtintruong ?? false,
                    cothongtindonvikhac:this.baibao.sanpham.cothongtindonvikhac ?? false,
                    id_thongtinnoikhac:this.baibao.sanpham.thongtinnoikhac?.id ?? null,
                    conhantaitro:this.baibao.sanpham.conhantaitro ?? false,
                    id_donvitaitro:this.baibao.sanpham.donvitaitro?.id ?? null,
                    chitietdonvitaitro:this.baibao.sanpham.chitietdonvitaitro ?? null,
                    ngaykekhai:this.baibao.sanpham.ngaykekhai,
                    diemquydoi:this.baibao.sanpham.diemquydoi,
                    gioquydoi:this.baibao.sanpham.gioquydoi,
                    thongtinchitiet:this.baibao.sanpham.thongtinchitiet,
                    capsanpham:this.baibao.sanpham.capsanpham,
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
                this.router.navigate(['/bai-bao'])
                return;
            }
        })
    }

    onCapNhatBaiBaoSanPham(){
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

        const data:CapNhatSanPham = {
            ...form.value,
            thoidiemcongbohoanthanh: dateConvert(form.get('thoidiemcongbohoanthanh')?.value),
            ngaykekhai: dateConvert(form.get('ngaykekhai')?.value)
        }

        this.isCapNhatLoading = true
        this.baiBaoService.capNhatSanPham(this.id,data)
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