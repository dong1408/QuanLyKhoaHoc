import {Component, Input} from "@angular/core";
import {MagazineRecognize} from "../../../core/types/tapchi/tap-chi.type";

@Component({
    selector:'app-recognize-card',
    templateUrl:'./recognize-card.component.html',
    styleUrls:['./recognize-card.component.css']
})

export class RecognizeCardComponent{
    @Input() recognize: MagazineRecognize
}