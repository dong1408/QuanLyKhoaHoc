import {NgModule} from "@angular/core";
import {CapNhatBaiBaoComponent} from "./capnhat-baibao.component";
import {CapNhatBaiBaoRoutingModule} from "./capnhat-baibao-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";

@NgModule({
    declarations:[
        CapNhatBaiBaoComponent
    ],
    imports:[
        CapNhatBaiBaoRoutingModule,
        CommonModule,
        ReactiveFormsModule,
    ],
    exports:[

    ]
})

export class CapNhatBaiBaoModule{}