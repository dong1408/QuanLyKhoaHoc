import {NgModule} from "@angular/core";
import {ChiTietDeTaiComponent} from "./detail.component";
import {PagingService} from "../../../core/services/paging.service";
import {ChiTietDeTaiRoutingModule} from "./detail-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzModalModule} from "ng-zorro-antd/modal";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../../shared/components/shared.module";
import {NzDatePickerModule} from "ng-zorro-antd/date-picker";
import {NzListModule} from "ng-zorro-antd/list";
import {NzUploadModule} from "ng-zorro-antd/upload";

@NgModule({
    declarations:[
        ChiTietDeTaiComponent
    ],
    imports: [
        ChiTietDeTaiRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzDividerModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzModalModule,
        NzPopconfirmModule,
        NzSelectModule,
        NzWaveModule,
        SharedModule,
        NzDatePickerModule,
        NzListModule,
        NzUploadModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class ChiTietDeTaiModule{

}