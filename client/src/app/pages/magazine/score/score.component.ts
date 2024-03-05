import {Component} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzModalService} from "ng-zorro-antd/modal";
import {MagazineRecognize, TinhDiemTapChi} from "../../../core/types/tap-chi.type";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";

@Component({
    selector:'app-magazine-score',
    templateUrl:'./score.component.html',
    styleUrls:['./score.component.css']
})

export class ScoreComponent{

    formRecognize: FormGroup
    isOpenRecognizeForm:boolean = false

    constructor(
        private modal: NzModalService,
        private fb:FormBuilder
    ) {
    }

    data:TinhDiemTapChi = {
        id:1,
        created_at:"30/3/2024",
        updated_at:"30/04/2024",
        ghichu:"Đây là ghi chú nhé fen !!",
        nguoicapnhat:{
            id:1,
            name:"Thiên Đạt",
            username:"3120410116",
            email:"hyperiondat@gmail.com"
        },
        nganhtinhdiem:{
            id:1,
            tennganhtinhdiem:"Nam Hoang",
            tennganhtinhdiem_en:"Nam Hoang",
            manganhtinhdiem:"1",
            created_at:"30/3/2024",
            updated_at:"30/04/2024",
        },
        chuyennganhtinhdiem:{
            created_at:"30/3/2024",
            updated_at:"30/04/2024",
            id:1,
            machuyennganh:"1",
            tenchuyennganh_en:"Thien Nhan",
            tenchuyennganh:"Thien Nhan"
        },
        diem:"100",
        namtinhdiem:"2024"
    }

    ngOnInit() {
        this.formRecognize = this.fb.group({
            khongduoccongnhan:[
                true,
                Validators.compose([
                    Validators.required
                ])
            ],
            ghichu:[
                null,
                Validators.compose([
                    noWhiteSpaceValidator()
                ])
            ]
        })
    }

    openRecognizeForm(){
        this.isOpenRecognizeForm = !this.isOpenRecognizeForm
    }

    updateMagazineRecognize(){
        const data = this.formRecognize.value
        console.log(data)
    }
}