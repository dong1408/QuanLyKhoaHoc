import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {
    combineLatest,
    debounceTime,
    distinctUntilChanged,
    forkJoin,
    Observable,
    Subject,
    switchMap,
    takeUntil,
    tap
} from "rxjs";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ToChuc} from "../../../../../core/types/user-info/to-chuc.type";
import {VaiTroTacGia} from "../../../../../core/types/sanpham/vai-tro-tac-gia.type";
import {PhanLoaiDeTai} from "../../../../../core/types/detai/phan-loai-de-tai.type";
import { User } from "src/app/core/types/user/user.type";
import {LoadingService} from "../../../../../core/services/loading.service";
import {ToChucService} from "../../../../../core/services/user-info/to-chuc.service";
import {UserService} from "../../../../../core/services/user/user.service";
import {PagingService} from "../../../../../core/services/paging.service";
import {VaiTroService} from "../../../../../core/services/sanpham/vai-tro.service";
import {DeTaiService} from "../../../../../core/services/detai/de-tai.service";
import {PhanLoaiDeTaiService} from "../../../../../core/services/detai/phan-loai-de-tai.service";
import {noWhiteSpaceValidator} from "../../../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../../../shared/validators/valid-value.validator";
import {TaoDeTai} from "../../../../../core/types/detai/de-tai.type";
import {dateConvert} from "../../../../../shared/commons/utilities";

@Component({
    selector:'app-taikhoan-detai-create',
    styleUrls:['./create.component.css'],
    templateUrl:'./create.component.html'
})

export class TaoDeTaiComponent implements OnInit,OnDestroy{
    tochucs:ToChuc[]
    vaiTros:VaiTroTacGia[]
    phanLoais:PhanLoaiDeTai[]

    users:User[]

    createForm:FormGroup
    isCreate:boolean = false
    isGetUsers:boolean = false

    destroy$ = new Subject<void>()

    search$:Observable<[string]>

    private firstSearch:boolean = false

    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private toChucService:ToChucService,
        private userService:UserService,
        private pagingService:PagingService,
        private vaiTroService:VaiTroService,
        private deTaiService:DeTaiService,
        private phanLoaiDeTaiService:PhanLoaiDeTaiService
    ) {
    }

    ngOnInit() {
        this.createForm = this.fb.group({
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
            sanpham_tacgia:this.fb.array([]),

            users: [
                null
            ],

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

            loaiminhchung:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            url_minhchung:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator(),
                    Validators.required
                ])
            ]

        })


        this.createForm.get("conhantaitro")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("id_donvitaitro")?.enable()
                this.createForm.get("chitietdonvitaitro")?.enable()
            }else{
                this.createForm.get("chitietdonvitaitro")?.disable()
                this.createForm.get("id_donvitaitro")?.disable()
                this.createForm.get("chitietdonvitaitro")?.reset()
                this.createForm.get("id_donvitaitro")?.reset()
            }
        })

        this.createForm.get("cothongtindonvikhac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("id_thongtinnoikhac")?.enable()
            }else{
                this.createForm.get("id_thongtinnoikhac")?.disable()
                this.createForm.get("id_thongtinnoikhac")?.reset()
            }
        })

        this.createForm.get("detaihoptac")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("id_tochuchoptac")?.enable()
                this.createForm.get("tylekinhphidonvihoptac")?.enable()
            }else{
                this.createForm.get("id_tochuchoptac")?.disable()
                this.createForm.get("tylekinhphidonvihoptac")?.disable()
                this.createForm.get("id_tochuchoptac")?.reset()
                this.createForm.get("tylekinhphidonvihoptac")?.reset()
            }
        })

        this.createForm.get("ngoaitruong")?.valueChanges.pipe(
            takeUntil(this.destroy$)
        ).subscribe(select => {
            if(select === true){
                this.createForm.get("truongchutri")?.enable()
                this.createForm.get("id_tochucchuquan")?.enable()

                this.createForm.get("id_loaidetai")?.disable()
                this.createForm.get("id_loaidetai")?.reset()
            }else{
                this.createForm.get("truongchutri")?.disable()
                this.createForm.get("id_tochucchuquan")?.disable()
                this.createForm.get("id_tochucchuquan")?.reset()
                this.createForm.get("truongchutri")?.reset()

                this.createForm.get("id_loaidetai")?.enable()
            }
        })

        this.loadingService.startLoading()
        forkJoin([
            this.toChucService.getAllToChuc(),
            this.vaiTroService.getVaiTroDeTai(),
            this.phanLoaiDeTaiService.getPhanLoaiDeTai()
        ],(tcResponse,vtResponse,plResponse) => {
            return {
                listTC: tcResponse.data,
                listVT: vtResponse.data,
                listPL: plResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.tochucs = response.listTC
                this.vaiTros = response.listVT
                this.phanLoais = response.listPL
                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    'Lỗi',
                    'Có lỗi xảy ra, vui lòng thử lại sau'
                )

                console.log(error)
                this.loadingService.stopLoading()
            }
        })
    }

    addGuestControls(){
        const control = this.fb.group({
            id_tacgia:[null],
            tentacgia:[
                null,
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator()
                ])
            ],
            thutu:[null],
            tyledonggop:[null],
            id_vaitro:[null]
        })
        const formArray = this.createForm.get('sanpham_tacgia') as FormArray
        formArray.push(control)

    }

    getAllUser(){
        this.isGetUsers = true
        this.search$ = combineLatest([
            this.pagingService.keyword$,
        ]).pipe(
            takeUntil(this.destroy$)
        )

        this.search$.pipe(
            takeUntil(this.destroy$),
            tap(() => this.isGetUsers = true),
            debounceTime(700),
            distinctUntilChanged(),
            switchMap(([ keyword]) => {
                return this.userService.getAllUsers( keyword)
            })
        ).subscribe({
            next:(response) => {
                this.users = response.data
                this.isGetUsers = false
            },
            error:(error) => {
                this.notificationService.create(
                    "error",
                    "Lỗi",
                    error
                )
                this.isGetUsers = false
            }
        })
    }

    onSearchUser(event:any){
        if(!this.firstSearch && event.length >= 3){
            this.getAllUser()
        }
        if(event && event.length >= 3){
            this.pagingService.updateKeyword(event)
            this.firstSearch = true
        }
        if(event.length <= 0){
            console.log("reset đi ?")
            this.createForm.get("users")?.reset()
        }
    }

    onSubmit(){
        const form = this.createForm
        const arrayForm = this.createForm.get('sanpham_tacgia') as FormArray
        if(form.invalid || arrayForm.invalid){
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
        if(arrayForm.length <= 0){
            this.notificationService.create(
                'error',
                'Lỗi',
                'Vui lòng chọn tác giả'
            )
            return;
        }

        const data:TaoDeTai = {
            sanpham:{
                tensanpham: form.get('tensanpham')?.value,
                tongsotacgia: form.get('tongsotacgia')?.value,
                solandaquydoi : form.get('solandaquydoi')?.value,
                diemquydoi: form.get('diemquydoi')?.value,
                gioquydoi : form.get('gioquydoi')?.value,
                thongtinchitiet: form.get('thongtinchitiet')?.value,
                capsanpham: form.get('capsanpham')?.value,
                thoidiemcongbohoanthanh: dateConvert(form.get('thoidiemcongbohoanthanh')?.value.toString())!!,
                cosudungemailtruong:form.get('cosudungemailtruong')?.value ?? false,
                cosudungemaildonvikhac: form.get('cosudungemaildonvikhac')?.value ?? false,
                cothongtintruong : form.get('cothongtintruong')?.value ?? false,
                cothongtindonvikhac : form.get('cothongtindonvikhac')?.value ?? false,
                id_thongtinnoikhac : form.get('cothongtindonvikhac')?.value === true ? form.get('id_thongtinnoikhac')?.value : null,
                conhantaitro : form.get('conhantaitro')?.value ?? false,
                id_donvitaitro :form.get('conhantaitro')?.value === true ? form.get('id_donvitaitro')?.value : null,
                chitietdonvitaitro: form.get('conhantaitro')?.value === true ? form.get('chitietdonvitaitro')?.value : null
            },
            sanpham_tacgia: form.get('sanpham_tacgia')?.value,
            fileminhchungsanpham:{
                url:form.get('url_minhchung')?.value,
                loaiminhchung: form.get('loaiminhchung')?.value ?? null
            },
            maso:form.get('maso')?.value,
            ngoaitruong:form.get('ngoaitruong')?.value ?? false,
            truongchutri: form.get('ngoaitruong')?.value === true ? form.get('truongchutri')?.value : null,
            id_tochucchuquan : form.get('ngoaitruong')?.value === true ? form.get('id_tochucchuquan')?.value : null,
            id_loaidetai: form.get('ngoaitruong')?.value === false ? form.get('id_loaidetai')?.value : null,
            detaihoptac: form.get('detaihoptac')?.value ?? false,
            id_tochuchoptac: form.get('detaihoptac')?.value === true ? form.get('id_tochuchoptac')?.value : null,
            tylekinhphidonvihoptac: form.get('detaihoptac')?.value === true ? form.get('tylekinhphidonvihoptac')?.value : null,
            capdetai: form.get('capdetai')?.value ?? null
        }

        this.isCreate = true
        this.deTaiService.taoDeTai(data)
            .pipe(
                takeUntil(this.destroy$)
            ).subscribe({
            next:(response) =>{
                this.notificationService.create(
                    'success',
                    "Thành Công",
                    response.message
                )
                this.isCreate = false
                const formArray = this.createForm.get('sanpham_tacgia') as FormArray
                formArray.clear()
                this.createForm.reset()
            },
            error:(error) =>{
                this.notificationService.create(
                    'error',
                    "Lỗi",
                    error
                )
                this.isCreate = false
            }
        })
    }

    onSelectUser(event:any){
        if(!event){
            return;
        }
        else{
            const data:User = event;
            const formArray = this.createForm.get('sanpham_tacgia') as FormArray
            const control = this.fb.group({
                id_tacgia:[data.id],
                tentacgia:[
                    data.name,
                    Validators.compose([
                        Validators.required,
                        noWhiteSpaceValidator
                    ])
                ],
                thutu:[null],
                tyledonggop:[null],
                id_vaitro:[null]
            })
            formArray.push(control);
            this.createForm.get("users")?.setValue(null)
        }
    }

    removeUser(index:number){
        (this.createForm.get('sanpham_tacgia') as FormArray).removeAt(index);
    }

    get sanphamTacgiaControls() {
        return (this.createForm.get('sanpham_tacgia') as FormArray).controls;
    }


    ngOnDestroy() {
        this.destroy$.next()
        this.destroy$.complete()
        this.pagingService.resetValues()
    }
}