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
import {ChiTietTapChi, CreateTapChi, UpdateTapChi} from "../../../core/types/tapchi/tap-chi.type";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {ApiResponse} from "../../../core/types/api-response.type";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
    selector:"app-magazine-update",
    templateUrl:'./update.component.html',
    styleUrls:['./update.component.css']
})

export class MagazineUpdateComponent implements OnInit,OnDestroy{
    id:number

    tapchi:ChiTietTapChi

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
        private tapChiService:TapChiService,
        private _router:ActivatedRoute,
        private router:Router
    ) {
    }

    ngOnInit() {

        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/tap-chi"])
                return;
            }
        })

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
            this.quocGiaService.getAllQuocGia(),
            this.nhaXuatBanService.getAllNhaXuatBan(),
            this.tapChiService.getChiTietTapChi(this.id)
        ],(gsResponse,qgResponse,nxbResponse,tacResponse) => {
            return {
                listGS: gsResponse.data,
                listQG: qgResponse.data,
                listNXB: nxbResponse.data,
                tapchi:tacResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.hoiDongGiaoSus = response.listGS
                this.quocGias = response.listQG
                this.nhaXuatBans = response.listNXB
                this.tapchi = response.tapchi

                if(this.tapchi.donvichuquan){
                    this.tochucs = [...this.tochucs,this.tapchi.donvichuquan]
                }

                if(this.tapchi.addresscity){
                    this.tinhThanhs = [...this.tinhThanhs,this.tapchi.addresscity]
                }

                this.createForm.patchValue({
                    name: this.tapchi.name,
                    issn: this.tapchi.issn ?? null,
                    eissn: this.tapchi.eissn ?? null,
                    pissn: this.tapchi.pissn ?? null,
                    website: this.tapchi.website ?? null,
                    quocte: this.tapchi.quocte ?? null,
                    address: this.tapchi.address ?? null,
                    id_nhaxuatban: this.tapchi.nhaxuatban?.id ?? null,
                    id_donvichuquan: this.tapchi.donvichuquan?.id ?? null,
                    id_address_city: this.tapchi.addresscity?.id ?? null,
                    id_address_country:this.tapchi.addresscountry?.id ?? null,
                    dmnganhtheohdgs: this.tapchi.hoidonggiaosus?.map(item => item.id)
                })

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

        const data:UpdateTapChi = {
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
        this.tapChiService.updateTapChi(this.id,data).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    'Thành Công',
                    response.message
                )
                this.iscreateLoading = false
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