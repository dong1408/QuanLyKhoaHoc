import {NgModule} from "@angular/core";
import {BaoCaoTienDoComponent} from "./bao-cao-tien-do.component";
import {PagingService} from "../../../core/services/paging.service";
import {BaoCaoTienDoRoutingModule} from "./bao-cao-tien-do-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzModalModule} from "ng-zorro-antd/modal";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../../shared/components/shared.module";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";

@NgModule({
    declarations:[
      BaoCaoTienDoComponent
    ],
    imports: [
        BaoCaoTienDoRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzModalModule,
        NzPaginationModule,
        NzSelectModule,
        NzWaveModule,
        SharedModule,
        NzDatePickerModule
    ],
    providers:[
        PagingService
    ]
})

export class BaoCaoTienDoModule{}