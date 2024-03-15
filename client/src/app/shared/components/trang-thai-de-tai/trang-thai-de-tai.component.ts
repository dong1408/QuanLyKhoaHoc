import {Component, Input} from "@angular/core";
import {NghiemThu, TuyenChon, XetDuyet} from "../../../core/types/detai/de-tai.type";
import {ConstantsService} from "../../../core/services/constants.service";

@Component({
    selector:"app-detai-trangthai",
    templateUrl:'./trang-thai-de-tai.component.html',
    styleUrls:['./trang-thai-de-tai.component.css']
})

export class TrangThaiDeTaiComponent{
    @Input() xetduyet:XetDuyet | undefined
    @Input() tuyenchon:TuyenChon | undefined
    @Input() nghiemthu:NghiemThu | undefined

    constructor(public AppConstant:ConstantsService) {
    }
}