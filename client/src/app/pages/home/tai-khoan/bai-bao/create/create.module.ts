import {NgModule} from "@angular/core";
import {BaiBaoCreateComponent} from "./create.component";
import {CommonModule} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {BaiBaoCreateRoutingModule} from "./create-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {SharedModule} from "../../../../../shared/components/shared.module";
import {PagingService} from "../../../../../core/services/paging.service";

@NgModule({
    declarations:[
        BaiBaoCreateComponent
    ],
    imports: [
        CommonModule,
        ReactiveFormsModule,
        BaiBaoCreateRoutingModule,
        NzButtonModule,
        NzIconModule,
        NzWaveModule,
        NzFormModule,
        NzGridModule,
        NzInputModule,
        NzSelectModule,
        FormsModule,
        NzDividerModule,
        NzDatePickerModule,
        SharedModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class BaiBaoCreateModule{}