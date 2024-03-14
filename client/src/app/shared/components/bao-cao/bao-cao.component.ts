import {Component, Input} from "@angular/core";
import {BaoBaoTienDo} from "../../../core/types/detai/de-tai.type";

@Component({
    selector:'app-detai-baocao-card',
    templateUrl:'./bao-cao.component.html',
    styleUrls:['./bao-cao.component.css']
})

export class BaoCaoComponent{
    @Input() baocao:BaoBaoTienDo
}