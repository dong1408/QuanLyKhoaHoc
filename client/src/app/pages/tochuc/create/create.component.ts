import {Component, OnDestroy, OnInit} from "@angular/core";
import {LoadingService} from "../../../core/services/loading.service";
import {QuocGiaService} from "../../../core/services/user-info/quoc-gia.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {forkJoin, Subject, takeUntil} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {QuocGia} from "../../../core/types/user-info/quoc-gia.type";
import {TinhThanh} from "../../../core/types/user-info/tinh-thanh.type";
import {PhanLoaiToChuc, TaoToChuc} from "../../../core/types/user-info/to-chuc.type";
import {TinhThanhService} from "../../../core/services/user-info/tinh-thanh.service";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {PhanLoaiToChucService} from "../../../core/services/user-info/phan-loai-to-chuc.service";

@Component({
    selector:'app-tochuc-create',
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class TaoToChucComponent implements OnInit,OnDestroy{

    createForm:FormGroup

    isCreate:boolean = false

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
        private phanLoaiToChucService:PhanLoaiToChucService
    ) {

    }

    ngOnInit() {
        this.createForm = this.fb.group({
            matochuc:[
                null,
                Validators.compose([
                    Validators.required,
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
            this.phanLoaiToChucService.getAllPhanLoaiToChuc()
        ],(qgResponse,pltcResponse) => {
            return {
                listQG:qgResponse.data,
                listPLTC:pltcResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) =>{
                this.quocGias = response.listQG
                this.plToChuc = response.listPLTC
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

        const data:TaoToChuc = {
            tentochuc: form.get("tentochuc")?.value,
            dienthoai: form.get("dienthoai")?.value ?? null,
            website: form.get("website")?.value ?? null,
            matochuc: form.get("matochuc")?.value,
            tentochuc_en: form.get("tentochuc_en")?.value ?? null,
            address: form.get("address")?.value ?? null,
            id_phanloaitochuc: form.get("id_phanloaitochuc")?.value ?? null,
            id_address_country : form.get("id_address_country")?.value ?? null,
            id_address_city: form.get("id_address_country")?.value !== null ? form.get("id_address_city")?.value : null
        }

        this.isCreate = true

        this.toChucService.taoToChuc(data)
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
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.createForm.reset()
                this.isCreate = false
            }
        })
    }

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }

}