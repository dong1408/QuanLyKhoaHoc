import {Component, Input} from "@angular/core";
import {BaoCaoTienDo} from "../../../core/types/detai/de-tai.type";

@Component({
    selector:'app-detai-baocao-card',
    templateUrl:'./bao-cao.component.html',
    styleUrls:['./bao-cao.component.css']
})

export class BaoCaoComponent{
    @Input() baocao:BaoCaoTienDo
}