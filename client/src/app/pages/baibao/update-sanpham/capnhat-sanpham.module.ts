import {NgModule} from "@angular/core";
import {CapNhatSanPhamBaiBaoComponent} from "./capnhat-sanpham.component";
import {CapNhatSanPhamBaiBaoRoutingModule} from "./capnhat-sanpham-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";

@NgModule({
    declarations:[
        CapNhatSanPhamBaiBaoComponent
    ],
    imports:[
        CapNhatSanPhamBaiBaoRoutingModule,
        CommonModule,
        ReactiveFormsModule,
    ],
    exports:[

    ]
})

export class CapNhatSanPhamBaiBaoModule {}