import {Component, Input} from "@angular/core";
import {XepHangTapChi} from "../../../core/types/tap-chi.type";

@Component({
    selector:'app-magazine-rankcard',
    templateUrl:'./rank.component.html',
    styleUrls:['./rank.component.css']
})

export class RankCardComponent{
    @Input() rank:XepHangTapChi
}