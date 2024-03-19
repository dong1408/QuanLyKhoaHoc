import {NgModule} from "@angular/core";
import {TaiKhoanComponent} from "./tai-khoan.component";
import {TaiKhoanRoutingModule} from "./tai-khoan-routing.module";
import {NzDividerModule} from "ng-zorro-antd/divider";

@NgModule({
    declarations:[
        TaiKhoanComponent
    ],
    imports: [
        TaiKhoanRoutingModule,
        NzDividerModule
    ],
    exports:[

    ]
})

export class TaiKhoanModule{}