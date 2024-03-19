import {NgModule} from "@angular/core";
import {CapNhatDeTaiComponent} from "./capnhat-detai.component";
import {AsyncPipe, NgForOf, NgIf} from "@angular/common";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {ReactiveFormsModule} from "@angular/forms";
import {RouterLink} from "@angular/router";
import {CapNhatDeTaiRoutingModule} from "./capnhat-detai-routing.module";
import {SharedModule} from "../../../../../shared/components/shared.module";

@NgModule({
    declarations:[
        CapNhatDeTaiComponent
    ],
    imports: [
        AsyncPipe,
        NgForOf,
        NgIf,
        NzButtonModule,
        NzDatePickerModule,
        NzDividerModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzSelectModule,
        NzWaveModule,
        ReactiveFormsModule,
        SharedModule,
        RouterLink,
        CapNhatDeTaiRoutingModule

    ],
    exports:[

    ],
})

export class CapNhatDeTaiModule{

}