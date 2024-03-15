import {NgModule} from "@angular/core";
import {UserComponent} from "./user.component";
import {CommonModule} from "@angular/common";
import {PagingService} from "../../core/services/paging.service";
import {UserRoutingModule} from "./user-routing.module";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzModalModule} from "ng-zorro-antd/modal";

@NgModule({
    declarations:[
        UserComponent
    ],
    imports: [
        UserRoutingModule,
        CommonModule,
        FormsModule,
        NzButtonModule,
        NzIconModule,
        NzInputModule,
        NzPaginationModule,
        NzPopconfirmModule,
        NzSelectModule,
        NzTableModule,
        NzWaveModule,
        ReactiveFormsModule,
        NzFormModule,
        NzGridModule,
        NzModalModule
    ],
    providers:[
        PagingService
    ]
})

export class UserModule{}