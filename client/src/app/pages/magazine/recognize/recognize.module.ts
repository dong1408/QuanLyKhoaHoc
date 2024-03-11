import {NgModule} from "@angular/core";
import {RecognizeComponent} from "./recognize.component";
import {RecognizeRoutingModule} from "./recognize-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../../shared/components/shared.module";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzModalModule} from "ng-zorro-antd/modal";
import {PagingService} from "../../../core/services/paging.service";

@NgModule({
    declarations:[
        RecognizeComponent
    ],
    imports: [
        RecognizeRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzIconModule,
        NzTableModule,
        NzWaveModule,
        NzPaginationModule,
        NzFormModule,
        NzGridModule,
        NzInputModule,
        NzSelectModule,
        NzModalModule,
        SharedModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class RecognizeModule {}