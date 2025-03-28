import {NgModule} from "@angular/core";
import {CapNhatBaiBaoComponent} from "./capnhat-baibao.component";
import {CapNhatBaiBaoRoutingModule} from "./capnhat-baibao-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {SharedModule} from "../../../../../shared/components/shared.module";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzListModule} from "ng-zorro-antd/list";
import {NzModalModule} from "ng-zorro-antd/modal";

@NgModule({
    declarations:[
        CapNhatBaiBaoComponent
    ],
    imports: [
        CapNhatBaiBaoRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzSelectModule,
        NzWaveModule,
        SharedModule,
        NzDatePickerModule,
        NzDividerModule,
        NzListModule,
        NzModalModule,
    ],
    exports:[

    ]
})

export class CapNhatBaiBaoModule{}