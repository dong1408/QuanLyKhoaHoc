import {NgModule} from "@angular/core";
import {UserCreateComponent} from "./create.component";
import {UserCreateRoutingModule} from "./create-routing.module";
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
import {SharedModule} from "../../../shared/components/shared.module";
import {NzCheckboxModule} from "ng-zorro-antd/checkbox";

@NgModule({
    declarations:[
        UserCreateComponent,

    ],
    imports: [
        UserCreateRoutingModule,
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
        NzCheckboxModule
    ],
    exports:[

    ]
})

export class UserCreateModule{}