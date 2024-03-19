import {NgModule} from "@angular/core";
import {TaiKhoanComponent} from "./tai-khoan.component";
import {TaiKhoanRoutingModule} from "./tai-khoan-routing.module";

@NgModule({
    declarations:[
        TaiKhoanComponent
    ],
    imports:[
        TaiKhoanRoutingModule
    ],
    exports:[

    ]
})

export class TaiKhoanModule{}