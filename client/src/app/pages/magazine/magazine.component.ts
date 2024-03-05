import {Component, OnInit} from "@angular/core";
import {Magazine} from "../../core/types/tap-chi.type";

@Component({
    selector:'app-magazine',
    templateUrl:'./magazine.component.html',
    styleUrls:['./magazine.component.css']
})

export class MagazineComponent implements OnInit{
    magazines:Magazine[] = []

    currentButton:number = 1

    ngOnInit() {
        for(let i = 0 ;i < 17;i++){
            this.magazines.push({
                id:i,
                name:`${i} Axxxxxxxxxxxxxxxx`,
                quocte: i % 2 === 0,
                address: "Trảng Bom",
                trangthai: i % 2 === 0,
                created_at:"03/05/2024",
                updated_at:"03/05/2024",
                nguoithem:{
                    id:1,
                    username:"3120410116",
                    name:"Thiên Đạt",
                    email:"hyperiondat@gmail.com"
                }
            })
        }

        console.log(this.magazines)
    }

     onDeleteMagazine(id:number){

     }

     onChangeStatus(){

     }

     setCurrentButton(number:number){
        this.currentButton = number
     }

}