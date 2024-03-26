import {NgModule} from "@angular/core";
import {RankComponent} from "./rank.component";
import {CommonModule} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {SharedModule} from "../../../shared/components/shared.module";
import {PagingService} from "../../../core/services/paging.service";
import {RankRoutingModule} from "./rank-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzModalModule} from "ng-zorro-antd/modal";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzDividerModule} from "ng-zorro-antd/divider";

@NgModule({
    declarations:[
        RankComponent
    ],
    imports: [
        RankRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        FormsModule,
        SharedModule,
        NzButtonModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzModalModule,
        NzPaginationModule,
        NzSelectModule,
        NzWaveModule,
        NzDividerModule,
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class RankModule{}