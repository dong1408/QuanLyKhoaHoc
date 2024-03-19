import {NgModule} from "@angular/core";
import {CapNhatSanPhamDeTaiComponent} from "./capnhat-sanpham.component";
import {CapNhatSanPhamDeTaiRoutingModule} from "./capnhat-sanpham-routing.module";
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

@NgModule({
    declarations:[
        CapNhatSanPhamDeTaiComponent
    ],
    imports: [
        CapNhatSanPhamDeTaiRoutingModule,
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
    ],
    exports:[

    ]
})

export class CapNhatSanPhamDeTaiModule {}