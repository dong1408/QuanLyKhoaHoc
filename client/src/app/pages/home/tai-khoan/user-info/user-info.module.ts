import {NgModule} from "@angular/core";
import {UserInfoComponent} from "./user-info.component";
import {UserInfoRoutingModule} from "./user-info-routing.module";
import {AsyncPipe, NgForOf, NgIf} from "@angular/common";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {ReactiveFormsModule} from "@angular/forms";
import {SharedModule} from "../../../../shared/components/shared.module";
import {NzTabsModule} from "ng-zorro-antd/tabs";

@NgModule({
    declarations:[
        UserInfoComponent
    ],
    imports: [
        UserInfoRoutingModule,
        AsyncPipe,
        NgForOf,
        NgIf,
        NzButtonModule,
        NzDatePickerModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzSelectModule,
        NzWaveModule,
        ReactiveFormsModule,
        SharedModule,
        NzTabsModule
    ],
    exports:[

    ]
})

export class UserInfoModule{}