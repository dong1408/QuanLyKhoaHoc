import {NgModule} from "@angular/core";
import {UpdateRoleComponent} from "./update.component";
import {UpdateRoleRoutingModule} from "./update-routing.module";
import {CommonModule} from "@angular/common";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {SharedModule} from "../../../shared/components/shared.module";
import {NzCheckboxModule} from "ng-zorro-antd/checkbox";

@NgModule({
    declarations:[
        UpdateRoleComponent
    ],
    imports: [
        UpdateRoleRoutingModule,
        CommonModule,
        NzButtonModule,
        NzIconModule,
        NzInputModule,
        NzPaginationModule,
        NzPopconfirmModule,
        NzSelectModule,
        NzTableModule,
        NzWaveModule,
        ReactiveFormsModule,
        NzDatePickerModule,
        NzDividerModule,
        NzFormModule,
        NzGridModule,
        SharedModule,
        NzCheckboxModule,
        FormsModule
    ],
    exports:[

    ]
})

export class UpdateRoleModule {}