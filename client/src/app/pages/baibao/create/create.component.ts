import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
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
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {User} from "../../../core/types/user/user.type";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {UserService} from "../../../core/services/user/user.service";
import {Magazine} from "../../../core/types/tapchi/tap-chi.type";
import {TaoBaiTao} from "../../../core/types/baibao/bai-bao.type";
import {dateConvert} from "../../../shared/commons/utilities";
import {PagingService} from "../../../core/services/paging.service";
import {VaiTroTacGia} from "../../../core/types/sanpham/vai-tro-tac-gia.type";
import {VaiTroService} from "../../../core/services/sanpham/vai-tro.service";
import {BaiBaoService} from "../../../core/services/baibao/bai-bao.service";

@Component({
    selector:"app-baibao-create",
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class BaiBaoCreateComponent implements OnInit,OnDestroy{

    tochucs:ToChuc[]
    tapChis:Magazine[]
    vaiTros:VaiTroTacGia[]

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
        private tapChiService:TapChiService,
        private userService:UserService,
        private pagingService:PagingService,
        private vaiTroService:VaiTroService,
        private baiBaoService:BaiBaoService
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

            users:[
                null
            ],
            doi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            url:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            received:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            accepted:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            published:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            abstract:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            keywords:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            volume:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            issue:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            number:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            pages:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],
            id_tapchi:[
                null,
                Validators.compose([
                    Validators.required
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

        this.loadingService.startLoading()
        forkJoin([
            this.toChucService.getAllToChuc(),
            this.tapChiService.getAllTapChi(),
            this.vaiTroService.getVaiTroBaiBao()
        ],(tcResponse,tacResponse,vtResponse) => {
            return {
                listTC: tcResponse.data,
                listTaC: tacResponse.data,
                listVT: vtResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.tochucs = response.listTC
                this.tapChis = response.listTaC
                this.vaiTros = response.listVT
                this.loadingService.stopLoading()
                console.log(response)
            },
            error:(error) =>{
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

        const data:TaoBaiTao = {
            sanpham:{
                tensanpham: form.get('tensanpham')?.value,
                tongsotacgia: form.get('tongsotacgia')?.value,
                solandaquydoi : form.get('solandaquydoi')?.value,
                diemquydoi: form.get('diemquydoi')?.value,
                gioquydoi : form.get('gioquydoi')?.value,
                thongtinchitiet: form.get('thongtinchitiet')?.value,
                capsanpham: form.get('capsanpham')?.value,
                thoidiemcongbohoanthanh: dateConvert(form.get('thoidiemcongbohoanthanh')?.value.toString()),
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
            doi:form.get('doi')?.value,
            url:form.get('url')?.value,
            received:form.get('received')?.value,
            accepted:form.get('accepted')?.value,
            published:form.get('published')?.value,
            abstract:form.get('abstract')?.value,
            keywords:form.get('keywords')?.value,
            id_tapchi:form.get('id_tapchi')?.value,
            volume:form.get('volume')?.value,
            issue:form.get('issue')?.value,
            number:form.get('number')?.value,
            pages:form.get('pages')?.value,
        }
        this.isCreate = true
        this.baiBaoService.taoBaiBao(data)
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
            error:(error) => {
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