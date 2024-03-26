import {NgModule} from "@angular/core";
import {ChiTietBaiBaoComponent} from "./detail.component";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {ChiTietBaiBaoRoutingModule} from "./detail-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzTagModule} from "ng-zorro-antd/tag";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzModalModule} from "ng-zorro-antd/modal";
import {NzSelectModule} from "ng-zorro-antd/select";
import {SharedModule} from "../../../../../shared/components/shared.module";
import {PagingService} from "../../../../../core/services/paging.service";
import {NzListModule} from "ng-zorro-antd/list";

@NgModule({
    declarations:[
        ChiTietBaiBaoComponent
    ],
    imports: [
        ChiTietBaiBaoRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzDividerModule,
        NzIconModule,
        NzPopconfirmModule,
        NzWaveModule,
        SharedModule,
        NzTagModule,
        NzFormModule,
        NzGridModule,
        NzInputModule,
        NzModalModule,
        NzSelectModule,
        NzListModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class ChiTietBaiBaoModule{}