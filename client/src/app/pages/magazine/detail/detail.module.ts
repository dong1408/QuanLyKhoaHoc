import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {SharedModule} from "../../../shared/components/shared.module";
import {PagingService} from "../../../core/services/paging.service";
import {MagazineDetailRoutingModule} from "./detail-routing.module";
import {MagazineDetailComponent} from "./detail.component";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzDividerModule} from "ng-zorro-antd/divider";

@NgModule({
    declarations:[
        MagazineDetailComponent
    ],
    imports: [
        MagazineDetailRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        FormsModule,
        SharedModule,
        NzButtonModule,
        NzIconModule,
        NzInputModule,
        NzPaginationModule,
        NzPopconfirmModule,
        NzSelectModule,
        NzTableModule,
        NzWaveModule,
        NzDividerModule,
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class MagazineDetailModule {}