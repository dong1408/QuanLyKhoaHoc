import {Component, OnDestroy, OnInit} from "@angular/core";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {forkJoin, Subject, takeUntil} from "rxjs";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {User} from "../../../core/types/user/user.type";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {UserService} from "../../../core/services/user/user.service";
import {Magazine} from "../../../core/types/tapchi/tap-chi.type";
import {TaoBaiTao} from "../../../core/types/baibao/bai-bao.type";
import {dateConvert} from "../../../shared/commons/utilities";

@Component({
    selector:"app-baibao-create",
    templateUrl:'./create.component.html',
    styleUrls:['./create.component.css']
})

export class BaiBaoCreateComponent implements OnInit,OnDestroy{

    tochucs:ToChuc[]
    tapChis:Magazine[]
    users:User[]

    createForm:FormGroup
    isCreate:boolean = false

    destroy$ = new Subject<void>()


    constructor(
        private fb:FormBuilder,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private toChucService:ToChucService,
        private tapChiService:TapChiService,
        private userService:UserService,
    ) {
    }

    ngOnInit() {
        this.createForm = this.fb.group({
            tensanpham:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
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
                    noWhiteSpaceValidator
                ]),
            ],
            diemquydoi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            gioquydoi:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            thongtinchitiet:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            capsanpham:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
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
                }
            ],
            id_donvitaitro:[
                {
                    value:null,
                    disabled:true
                }
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

        this.loadingService.startLoading()
        forkJoin([
            this.toChucService.getAllToChuc(),
            this.tapChiService.getAllTapChi(),
            this.userService.getAllUsers()
        ],(tcResponse,tacResponse,uResponse) => {
            return {
                listTC: tcResponse.data,
                listTaC: tacResponse.data,
                listU:uResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.tochucs = response.listTC
                this.tapChis = response.listTaC
                this.users = response.listU
                this.loadingService.stopLoading()
            },
            error:(error) =>{
                this.loadingService.stopLoading()
            }
        })
    }
    addUserControls(user:User | any){
        const control = this.fb.group({
            id:[user.id],
            tentacgia:[
                {
                    value:user.name,
                    disabled:true
                },
                Validators.compose([
                    Validators.required,
                    noWhiteSpaceValidator
                ])
            ],
            thutu:[null],
            tyledonggop:[null],
            id_vaitro:[null]
        })
        return control
    }

    addGuestControls(){
        const control = this.fb.group({
            id:[null],
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

    onSubmit(){
        const form = this.createForm
        // if(form.invalid){
        //     this.notificationService.create(
        //         'error',
        //         'Lỗi',
        //         'Vui lòng điền đúng yêu cầu của form'
        //     )
        //     return;
        // }
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
        console.log(data)
    }

    onSelectUser(event:any){
        if(!event){
            return;
        }
        else{
            const data:User = event;
            const formArray = this.createForm.get('sanpham_tacgia') as FormArray
                const control = this.fb.group({
                    id:[data.id],
                    tentacgia:[
                        {
                            value:data.name,
                            disabled:true
                        },
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
                this.createForm.get("users")?.reset()
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
    }

    protected readonly FormArray = FormArray;
}