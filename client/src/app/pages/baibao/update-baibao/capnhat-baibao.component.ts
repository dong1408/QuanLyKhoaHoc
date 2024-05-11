import {Component, OnDestroy, OnInit} from "@angular/core";
import {BaiBaoService} from "../../../core/services/baibao/bai-bao.service";
import {LoadingService} from "../../../core/services/loading.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {TapChiService} from "../../../core/services/tapchi/tap-chi.service";
import {BehaviorSubject, debounceTime, forkJoin, Observable, Subject, switchMap, takeUntil} from "rxjs";
import {CapNhatBaiBao, ChiTietBaiBao} from "../../../core/types/baibao/bai-bao.type";
import {ActivatedRoute, Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Magazine} from "../../../core/types/tapchi/tap-chi.type";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";
import {dateConvert} from "../../../shared/commons/utilities";
import {Keyword} from "../../../core/types/baibao/keyword.type";
import {ApiResponse} from "../../../core/types/api-response.type";
import {KeywordService} from "../../../core/services/baibao/keyword.service";

@Component({
    selector:"app-baibao-capnhat",
    templateUrl:"./capnhat-baibao.component.html",
    styleUrls:["./capnhat-baibao.component.css"]
})

export class CapNhatBaiBaoComponent implements OnInit,OnDestroy{
    id:number
    baibao:ChiTietBaiBao
    tapChis:Magazine[] = []
    keywords:Keyword[] = []

    isCapNhatLoading:boolean = false

    capNhatForm:FormGroup

    destroy$ = new Subject<void>()

    isGetTapChi:boolean = false
    isGetKeyword:boolean = false

    searchKeyword$ = new BehaviorSubject('');
    searchTapChi$ = new BehaviorSubject('');

    constructor(
        private baiBaoService:BaiBaoService,
        public loadingService:LoadingService,
        private notificationService:NzNotificationService,
        private tapChiService:TapChiService,
        private _router: ActivatedRoute,
        private router:Router,
        private fb:FormBuilder,
        private keywordService:KeywordService
    ) {
    }

    ngOnInit() {
        this._router.paramMap.pipe(takeUntil(this.destroy$)).subscribe((params) => {
            if(parseInt(params.get("id") as string)){
                this.id = parseInt(params.get("id") as string)
            }else{
                this.router.navigate(["/admin/bai-bao"])
                return;
            }
        })

        this.capNhatForm = this.fb.group({
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
                ])
            ],
        })

        this.onGetSearchTapChi()
        this.onGetSearchKeyword()
        this.loadingService.startLoading()

        forkJoin([
            this.baiBaoService.getChiTietBaiBao(this.id),
        ],
            (bbResponse) => {
                return {
                    baibao:bbResponse.data,
                }
            }
        ).pipe(
            takeUntil(this.destroy$)
        ).subscribe({
            next:(response) => {
                this.baibao = response.baibao
                this.tapChis = [...this.tapChis,this.baibao.tapchi]
                if(this.baibao.keywords !== null){
                    this.keywords = [...this.keywords,...this.baibao.keywords]
                }

                this.capNhatForm.patchValue({
                    doi:this.baibao.doi ?? null,
                    url:this.baibao.url ?? null,
                    received:this.baibao.received ?? null,
                    accepted:this.baibao.accepted ?? null,
                    published:this.baibao.published ?? null,
                    abstract:this.baibao.abstract ?? null,
                    keywords:this.baibao.keywords ?? null,
                    volume:this.baibao.volume ?? null,
                    issue:this.baibao.issue ?? null,
                    number:this.baibao.number ?? null,
                    pages:this.baibao.number ?? null,
                    id_tapchi:this.baibao.tapchi
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
                this.router.navigate(['/admin/bai-bao'])
                return;
            }
        })
    }

    onGetSearchKeyword(){
        const listKeyword = (keyword:string):Observable<ApiResponse<Keyword[]>> =>  this.keywordService.getAllKeyword(keyword)
        const optionList$:Observable<ApiResponse<Keyword[]>> = this.searchKeyword$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listKeyword))

        optionList$.subscribe(data => {
            this.keywords = data.data
            this.isGetKeyword = false
        })
    }

    onSearchKeyword(event:any){
        if(event && event !== ""){
            this.isGetKeyword = true
            this.searchKeyword$.next(event)
        }
    }

    onGetSearchTapChi(){
        const listTapChi = (keyword:string):Observable<ApiResponse<Magazine[]>> =>  this.tapChiService.getAllTapChi(keyword)
        const optionList$:Observable<ApiResponse<Magazine[]>> = this.searchTapChi$
            .asObservable()
            .pipe(debounceTime(700))
            .pipe(switchMap(listTapChi))

        optionList$.subscribe(data => {
            this.tapChis = data.data
            this.isGetTapChi = false
        })
    }

    onSearchTapChi(event:any){
        if(event && event !== ""){
            this.isGetTapChi = true
            this.searchTapChi$.next(event)
        }
    }

    onCapNhatBaiBao(){
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

        const data:CapNhatBaiBao = {
            ...form.value,
            received:form.get('received')?.value ? dateConvert(form.get('received')?.value.toString()) : null,
            accepted:form.get('accepted')?.value ? dateConvert(form.get('accepted')?.value.toString()) : null,
            published:form.get('published')?.value ? dateConvert(form.get('published')?.value.toString()) : null,
            tapchi:{
                id_tapchi: form.get("id_tapchi")?.value['id'] ?? null,
                name:form.get("id_tapchi")?.value['name'],
                issn:form.get("id_tapchi")?.value['issn'] ?? null,
                eissn:form.get("id_tapchi")?.value['eissn'] ?? null,
                pissn:form.get("id_tapchi")?.value['pissn'] ?? null,
                website:form.get("id_tapchi")?.value['website'] ?? null
            },
            keywords:form.get('keywords')?.value !== null ? form.get('keywords')?.value.map((item:Keyword) => {
                return {
                    id_keyword:item.id,
                    name:item.name
                }
            }) : null,
        }

        this.isCapNhatLoading = true
        this.baiBaoService.capNhatBaiBao(this.id,data)
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