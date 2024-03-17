import {NgModule} from "@angular/core";
import {UserUpdateComponent} from "./update.component";
import {UserUpdateRoutingModule} from "./update-routing.module";
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
        UserUpdateComponent,

    ],
    imports: [
        UserUpdateRoutingModule,
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

export class UserUpdateModule{}