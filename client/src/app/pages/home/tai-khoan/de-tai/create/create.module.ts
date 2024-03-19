import {NgModule} from "@angular/core";
import {TaoDeTaiComponent} from "./create.component";
import {ReactiveFormsModule} from "@angular/forms";
import {CommonModule} from "@angular/common";
import {TaoDeTaiRoutingModule} from "./create-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import { NzCheckboxModule } from 'ng-zorro-antd/checkbox';
import {SharedModule} from "../../../../../shared/components/shared.module";
import {PagingService} from "../../../../../core/services/paging.service";

@NgModule({
    declarations:[
        TaoDeTaiComponent
    ],
    imports: [
        TaoDeTaiRoutingModule,
        ReactiveFormsModule,
        CommonModule,
        NzButtonModule,
        NzDatePickerModule,
        NzDividerModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzSelectModule,
        NzWaveModule,
        SharedModule,
        NzCheckboxModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class TaoDeTaiModule{}