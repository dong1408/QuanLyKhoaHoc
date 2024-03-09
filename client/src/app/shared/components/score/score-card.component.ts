import {Component, Input} from "@angular/core";
import {TinhDiemTapChi} from "../../../core/types/tapchi/tap-chi.type";

@Component({
    selector:'app-score-card',
    templateUrl:'./score-card.component.html',
    styleUrls:['./score-card.component.css']
})

export class ScoreCardComponent{
    @Input() score:TinhDiemTapChi
}