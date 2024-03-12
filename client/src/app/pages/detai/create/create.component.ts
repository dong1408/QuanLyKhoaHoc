import {Component, OnDestroy, OnInit} from "@angular/core";
import {ToChuc} from "../../../core/types/user-info/to-chuc.type";
import {Magazine} from "../../../core/types/tapchi/tap-chi.type";
import {VaiTroTacGia} from "../../../core/types/sanpham/vai-tro-tac-gia.type";
import {User} from "../../../core/types/user/user.type";
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
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {ToChucService} from "../../../core/services/user-info/to-chuc.service";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {UserService} from "../../../core/services/user/user.service";
import {PagingService} from "../../../core/services/paging.service";
import {VaiTroService} from "../../../core/services/sanpham/vai-tro.service";
import {BaiBaoService} from "../../../core/services/baibao/bai-bao.service";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {validValuesValidator} from "../../../shared/validators/valid-value.validator";

@Component({
    selector:'app-detai-create',
    styleUrls:['./create.component.css'],
    templateUrl:'./create.component.html'
})

export class TaoDeTaiComponent implements OnInit,OnDestroy{
    tochucs:ToChuc[]
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
        private userService:UserService,
        private pagingService:PagingService,
        private vaiTroService:VaiTroService,
    ) {
    }

    ngOnInit() {
        this.createForm = this.fb.group({
            tensanpham: [
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            tongsotacgia: [
                0,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            solandaquydoi: [
                0,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            cosudungemailtruong: [
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            cosudungemaildonvikhac: [
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            cothongtintruong: [
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            cothongtindonvikhac: [
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            conhantaitro: [
                false,
                Validators.compose([
                    noWhiteSpaceValidator
                ])
            ],
            chitietdonvitaitro: [
                {
                    value: null,
                    disabled: true
                },
                Validators.compose([
                    noWhiteSpaceValidator
                ]),
            ],
            diemquydoi: [
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            gioquydoi: [
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            thongtinchitiet: [
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            capsanpham: [
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            thoidiemcongbohoanthanh: [
                null,
                Validators.compose([
                    noWhiteSpaceValidator,
                    Validators.required
                ])
            ],
            id_thongtinnoikhac: [
                {
                    value: null,
                    disabled: true
                }
            ],
            id_donvitaitro: [
                {
                    value: null,
                    disabled: true
                }
            ],
            sanpham_tacgia: this.fb.array([]),

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
                false,
            ],
            id_tochucchuquan:[
                null
            ],
            // nếu ngoaitruong === false
            id_loaidetai:[
                null
            ],
            detaihoptac:[
                false
            ],
            //nếu detaihoptac === true
            id_tochuchoptac:[
                null
            ],
            tylekinhphidonvihoptac:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ],

            //
            capdetai:[
                null,
                Validators.compose([
                    validValuesValidator(['Khoa','Cơ Sở','Tỉnh','Bộ','Ngành','Nhà nước','Nước ngoài']),
                    noWhiteSpaceValidator()
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
                this.createForm.get("id_tochuchoptac")?.enable()
                this.createForm.get("tylekinhphidonvihoptac")?.enable()
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
            }
        })

        this.loadingService.startLoading()
        forkJoin([
            this.toChucService.getAllToChuc(),
            this.vaiTroService.getVaiTroBaiBao()
        ],(tcResponse,vtResponse) => {
            return {
                listTC: tcResponse.data,
                listVT: vtResponse.data
            }
        }).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.tochucs = response.listTC
                this.vaiTros = response.listVT
                this.loadingService.stopLoading()
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