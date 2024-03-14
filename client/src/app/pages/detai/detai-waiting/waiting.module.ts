import {NgModule} from "@angular/core";
import {DeTaiWaitingComponent} from "./waiting.component";
import {DeTaiWaitingRoutingModule} from "./waiting-routing.module";
import {NgForOf, NgIf} from "@angular/common";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {PagingService} from "../../../core/services/paging.service";
import {ReactiveFormsModule} from "@angular/forms";

@NgModule({
    declarations:[
        DeTaiWaitingComponent
    ],
    imports: [
        DeTaiWaitingRoutingModule,
        NgForOf,
        NgIf,
        NzButtonModule,
        NzIconModule,
        NzInputModule,
        NzPaginationModule,
        NzPopconfirmModule,
        NzSelectModule,
        NzTableModule,
        NzWaveModule,
        ReactiveFormsModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})
export class DeTaiWaitingModule{}