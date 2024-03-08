import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {forkJoin, Subject, takeUntil} from "rxjs";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {HoiDongGiaoSu} from "../../../core/types/hoi-dong-giao-su.type";
import {TinhThanh} from "../../../core/types/tinh-thanh.type";
import {QuocGia} from "../../../core/types/quoc-gia.type";
import {ToChuc} from "../../../core/types/to-chuc.type";
import {HoiDongGiaoSuService} from "../../../core/services/hoi-dong-giao-su.service";
import {ToChucService} from "../../../core/services/to-chuc.service";
import {TinhThanhService} from "../../../core/services/tinh-thanh.service";
import {QuocGiaService} from "../../../core/services/quoc-gia.service";
import {NhaXuatBan} from "../../../core/types/nha-xuat-ban.type";
import {NhaXuatBanService} from "../../../core/services/nha-xuat-ban.service";
import {CreateTapChi} from "../../../core/types/tap-chi.type";
import {TapChiService} from "../../../core/services/tap-chi.service";

@Component({
    selector:"app-magazine-create",
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class MagazineCreateComponent implements OnInit,OnDestroy{

    iscreateLoading:boolean = false
    isTinhThanhLoading:boolean = false

    createForm:FormGroup

    destroy$ = new Subject<void>()

    hoiDongGiaoSus:HoiDongGiaoSu[] = []
    tinhThanhs:TinhThanh[] = []
    quocGias:QuocGia[] = []
    toChucs:ToChuc[] = []
    nhaXuatBans:NhaXuatBan[] = []

    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private hoiDongGiaoSuService:HoiDongGiaoSuService,
        private toChucService:ToChucService,
        private tinhThanhService:TinhThanhService,
        private quocGiaService:QuocGiaService,
        private nhaXuatBanService:NhaXuatBanService,
        private tapChiService:TapChiService
    ) {
    }

    ngOnInit() {
        this.createForm = this.fb.group({
            name:[
                null,
                Validators.compose([
                    Validators.required,
                    Validators.maxLength(255),
                    noWhiteSpaceValidator()
                ])
            ],
            issn:[
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
            eissn:[
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
            quocte:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            id_nhaxuatban:[
                null,
            ],
            id_donvichuquan:[
                null,
            ],
            address:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            id_address_city:[
                null,
            ],
            id_address_country:[
                null,
            ],
        })
        this.loadingService.startLoading()
        forkJoin([
            this.hoiDongGiaoSuService.getAllHDGS(),
            this.tinhThanhService.getAllTinhThanh(),
            this.quocGiaService.getAllQuocGia(),
            this.toChucService.getAllToChuc(),
            this.nhaXuatBanService.getAllNhaXuatBan()
        ],(gsResponse,ttResponse,qgResponse,tcResponse,nxbResponse) => {
            return {
                listGS: gsResponse.data,
                listTT: ttResponse.data,
                listQG: qgResponse.data,
                listTC: tcResponse.data,
                listNXB: nxbResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.hoiDongGiaoSus = response.listGS
                this.quocGias = response.listQG
                this.tinhThanhs = response.listTT
                this.toChucs = response.listTC
                this.nhaXuatBans = response.listNXB
                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.loadingService.stopLoading()
            }
        })
    }

    onCreateTapChi(){
        if(this.createForm.invalid){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng điền đúng yêu cầu của form'
            )
            return;
        }

        const data:CreateTapChi = {
            ...this.createForm.value,
            id_address_city: this.createForm.controls['id_address_country'].value ?? null,
            trangthai:false
        }
        this.iscreateLoading = true
        this.tapChiService.createTapChi(data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.iscreateLoading = false
                this.createForm.reset()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    error
                )
                this.iscreateLoading = false
            }
        })

    }


    onSelectChange(event:any){
        if(typeof(event) !== "number"){
            return;
        }
        this.tinhThanhs = []
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

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }

}