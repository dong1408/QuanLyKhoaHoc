import {Component, Input} from "@angular/core";
import {SanPham} from "../../../core/types/sanpham/san-pham.type";
import {ConstantsService} from "../../../core/services/constants.service";
import {SanPhamTacGia} from "../../../core/types/sanpham/vai-tro-tac-gia.type";

@Component({
    selector:"app-sanpham-component",
    styleUrls:['./san-pham.component.css'],
    templateUrl:'./san-pham.component.html'
})

export class SanPhamComponent{
    @Input() sanpham:SanPham
    @Input() sanpham_tacgias:SanPhamTacGia[]

    constructor(public AppConstant:ConstantsService) {
    }
}