import {Component, OnInit} from "@angular/core";
import {MagazineRecognize} from "../../../core/types/tap-chi.type";
import {data} from "autoprefixer";
import {NzModalRef, NzModalService} from "ng-zorro-antd/modal";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {noWhiteSpaceValidator} from "../../../shared/validators/no-white-space.validator";

@Component({
    selector:'app-magazine-recognize',
    templateUrl:'./recognize.component.html',
    styleUrls:['./recognize.component.css']
})

export class RecognizeComponent implements OnInit{


    formRecognize: FormGroup
    isOpenRecognizeForm:boolean = false

    constructor(
        private modal: NzModalService,
        private fb:FormBuilder
    ) {
    }

    data:MagazineRecognize = {
        id:1,
        created_at:"30/3/2024",
        updated_at:"30/04/2024",
        khongduoccongnhan:true,
        ghichu:"Đây là ghi chú nhé fen !!",
        nguoicapnhat:{
            id:1,
            name:"Thiên Đạt",
            username:"3120410116",
            email:"hyperiondat@gmail.com"
        }
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