import {Component, Input} from "@angular/core";
import {ChiTietBaiBao} from "../../../core/types/baibao/bai-bao.type";

@Component({
    selector:'app-baibao-component',
    templateUrl:'./bai-bao.component.html',
    styleUrls:['./bai-bao.component.css']
})

export class BaiBaoComponent{
    @Input() baibao:ChiTietBaiBao
}