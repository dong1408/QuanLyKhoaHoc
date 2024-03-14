import {Component, Input} from "@angular/core";
import {ChiTietDeTai} from "../../../core/types/detai/de-tai.type";

@Component({
    selector:'app-detai-component',
    templateUrl:'./de-tai.component.html',
    styleUrls:['./de-tai.component.css']
})

export class DeTaiComponent{
    @Input() detai:ChiTietDeTai
}