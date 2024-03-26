import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {HoiDongGiaoSu} from "../../../core/types/tapchi/hoi-dong-giao-su.type";
import {TinhThanh} from "../../../core/types/user-info/tinh-thanh.type";
import {QuocGia} from "../../../core/types/user-info/quoc-gia.type";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {HoiDongGiaoSuService} from "../../../core/services/tapchi/hoi-dong-giao-su.service";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {TinhThanhService} from "../../../core/services/user-info/tinh-thanh.service";
import {QuocGiaService} from "../../../core/services/user-info/quoc-gia.service";
import {NhaXuatBan} from "../../../core/types/nhaxuatban/nha-xuat-ban.type";
import {NhaXuatBanService} from "../../../core/services/nhaxuatban/nha-xuat-ban.service";
import {CreateTapChi} from "../../../core/types/tapchi/tap-chi.type";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {ApiResponse} from "../../../core/types/api-response.type";

@Component({
    selector:"app-magazine-create",
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class MagazineCreateComponent implements OnInit,OnDestroy{

    iscreateLoading:boolean = false
    isTinhThanhLoading:boolean = false
    isGetToChuc:boolean = false

    createForm:FormGroup

    destroy$ = new Subject<void>()

    hoiDongGiaoSus:HoiDongGiaoSu[] = []
    tinhThanhs:TinhThanh[] = []
    quocGias:QuocGia[] = []
    nhaXuatBans:NhaXuatBan[] = []
    tochucs:ToChuc[] = []

    searchToChuc$ = new BehaviorSubject('');


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
                null
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
            dmnganhtheohdgs:[
                null
            ]
        })

        this.onGetSearchToChuc()

        this.loadingService.startLoading()
        forkJoin([
            this.hoiDongGiaoSuService.getAllHDGS(),
            this.tinhThanhService.getAllTinhThanh(),
            this.quocGiaService.getAllQuocGia(),
            this.nhaXuatBanService.getAllNhaXuatBan()
        ],(gsResponse,ttResponse,qgResponse,nxbResponse) => {
            return {
                listGS: gsResponse.data,
                listTT: ttResponse.data,
                listQG: qgResponse.data,
                listNXB: nxbResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.hoiDongGiaoSus = response.listGS
                this.quocGias = response.listQG
                this.tinhThanhs = response.listTT
                this.nhaXuatBans = response.listNXB
                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.loadingService.stopLoading()
            }
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
            this.isGetToChuc = false
        })
    }

    onSearchToChuc(event:any){
        if(event && event !== ""){
            this.isGetToChuc = true
            this.searchToChuc$.next(event)
        }
    }

    onCreateTapChi(){
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

        const data:CreateTapChi = {
            name: form.get("name")?.value,
            issn: form.get("issn")?.value ?? null,
            eissn: form.get("eissn")?.value ?? null,
            pissn: form.get("pissn")?.value ?? null,
            website: form.get("website")?.value ?? null,
            quocte: form.get("quocte")?.value ?? null,
            id_nhaxuatban: form.get("id_nhaxuatban")?.value ?? null,
            id_donvichuquan : form.get("id_donvichuquan")?.value ?? null,
            address: form.get("address")?.value ?? null,
            id_address_city: form.get("id_address_city")?.value ?? null,
            id_address_country: form.get("id_address_country")?.value ?? null,
            dmnganhtheohdgs: form.get("dmnganhtheohdgs")?.value ?? null
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

    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
    }

}