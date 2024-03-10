import {NgModule} from "@angular/core";
import {ChiTietBaiBaoComponent} from "./detail.component";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {ChiTietBaiBaoRoutingModule} from "./detai-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../../shared/components/shared.module";

@NgModule({
    declarations:[
        ChiTietBaiBaoComponent
    ],
    imports: [
        ChiTietBaiBaoRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzDividerModule,
        NzIconModule,
        NzPopconfirmModule,
        NzWaveModule,
        SharedModule
    ],
    exports:[

    ]
})

export class ChiTietBaiBaoModule{}