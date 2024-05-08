import {Component, OnDestroy, OnInit} from "@angular/core";
import {LoadingService} from "../../../core/services/loading.service";
import {QuocGiaService} from "../../../core/services/user-info/quoc-gia.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {forkJoin, Subject, takeUntil} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {QuocGia} from "../../../core/types/user-info/quoc-gia.type";
import {TinhThanh} from "../../../core/types/user-info/tinh-thanh.type";
import {CapNhatToChuc, ChiTietToChuc, PhanLoaiToChuc, TaoToChuc} from "../../../core/types/user-info/to-chuc.type";
import {TinhThanhService} from "../../../core/services/user-info/tinh-thanh.service";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {ActivatedRoute, Router} from "@angular/router";
import {PhanLoaiToChucService} from "../../../core/services/user-info/phan-loai-to-chuc.service";

@Component({
    selector:'app-tochuc-update',
    templateUrl:'./update.component.html',
    styleUrls:['./update.component.css']
})

export class CapNhatToChucComponent implements OnInit,OnDestroy{
    id:number

    createForm:FormGroup

    isCreate:boolean = false

    tochuc:ChiTietToChuc

    destroy$ = new Subject<void>()

    quocGias:QuocGia[] = []
    tinhThanhs:TinhThanh[] = []
    plToChuc:PhanLoaiToChuc[] = []

    isTinhThanhLoading:boolean = false


    constructor(
        public loadingService:LoadingService,
        private quocGiaService:QuocGiaService,
        private fb:FormBuilder,
        private notificationService:NzNotificationService,
        private tinhThanhService:TinhThanhService,
        private toChucService:ToChucService,
        private router:Router,
        private _router:ActivatedRoute,
        private phanLoaiToChucService:PhanLoaiToChucService
    ) {

    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/to-chuc"])
                return;
            }
        })

        this.createForm = this.fb.group({
            matochuc:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            tentochuc:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            tentochuc_en:[
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
            address:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            dienthoai:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            id_address_city:[
                null
            ],
            id_address_country:[
                null
            ],
            id_phanloaitochuc:[
                null
            ]
        })

        this.loadingService.startLoading()
        forkJoin([
            this.quocGiaService.getAllQuocGia(),
            this.phanLoaiToChucService.getAllPhanLoaiToChuc(),
            this.toChucService.getChiTietToChuc(this.id)
        ],(qgResponse,pltcResponse,tResponse) => {
            return {
                listQG:qgResponse.data,
                listPLTC:pltcResponse.data,
                tochuc:tResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) =>{
                this.quocGias = response.listQG
                this.plToChuc = response.listPLTC
                this.tochuc = response.tochuc

                if(this.tochuc.addresscity){
                    this.tinhThanhs = [...this.tinhThanhs,this.tochuc.addresscity]
                }

                this.createForm.patchValue({
                    matochuc: this.tochuc.matochuc ?? null,
                    tentochuc:this.tochuc.tentochuc,
                    tentochuc_en:this.tochuc.tentochuc_en ?? null,
                    website: this.tochuc.website ?? null,
                    dienthoai: this.tochuc.dienthoai ?? null,
                    address : this.tochuc.address ?? null,
                    id_address_city: this.tochuc.addresscity?.id ?? null,
                    id_address_country: this.tochuc.addresscountry?.id ?? null ,
                    id_phanloaitochuc: this.tochuc.phanloaitochuc?.id ?? null,
                })

                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.loadingService.stopLoading()
            }
        })
    }

    onSelectChange(event:any){
        this.tinhThanhs = []
        this.createForm.get("id_address_city")?.reset()
        if(typeof(event) !== "number"){
            return;
        }
        this.isTinhThanhLoading = true
        this.tinhThanhService.getAllTinhThanhByQuocGia(event).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.tinhThanhs = response.data
                this.isTinhThanhLoading = false
            },
            error:(error) => {
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.isTinhThanhLoading = false
            }
        })
    }

    onSubmit(){
        const form = this.createForm
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

        const data:CapNhatToChuc = {
            tentochuc: form.get("tentochuc")?.value,
            dienthoai: form.get("dienthoai")?.value ?? null,
            website: form.get("website")?.value ?? null,
            matochuc: form.get("matochuc")?.value ?? null,
            tentochuc_en: form.get("tentochuc_en")?.value ?? null,
            address: form.get("address")?.value ?? null,
            id_phanloaitochuc: form.get("id_phanloaitochuc")?.value ?? null,
            id_address_country : form.get("id_address_country")?.value ?? null,
            id_address_city: form.get("id_address_country")?.value !== null ? form.get("id_address_city")?.value : null
        }

        this.isCreate = true

        this.toChucService.capNhatToChuc(this.id,data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.isCreate = false
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