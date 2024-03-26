import {Component, Input, OnChanges, OnInit, SimpleChanges} from "@angular/core";
import {SanPham} from "../../../core/types/sanpham/san-pham.type";
import {ConstantsService} from "../../../core/services/constants.service";
import {SanPhamTacGia, SanPhamTacGiaMerged} from "../../../core/types/sanpham/vai-tro-tac-gia.type";
import {mergedUsers} from "../../commons/utilities";

@Component({
    selector:"app-sanpham-component",
    styleUrls:['./san-pham.component.css'],
    templateUrl:'./san-pham.component.html'
})

export class SanPhamComponent implements OnInit,OnChanges{
    @Input() sanpham:SanPham
    @Input() sanpham_tacgias:SanPhamTacGia[]
    tacGiaMerged:SanPhamTacGiaMerged[] = []

    constructor(public AppConstant:ConstantsService){

    }

    ngOnChanges(changes: SimpleChanges) {
        if(changes["sanpham_tacgias"]){
            this.updateMergedUser()
        }
    }

    ngOnInit() {
        this.updateMergedUser()
    }

    private updateMergedUser() {
        this.tacGiaMerged = mergedUsers(this.sanpham_tacgias);
    }
}