import {NgModule} from "@angular/core";
import {ToChucComponent} from "./tochuc.component";
import {PagingService} from "../../core/services/paging.service";
import {NgForOf, NgIf} from "@angular/common";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzTableModule} from "ng-zorro-antd/table";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {ReactiveFormsModule} from "@angular/forms";
import {RouterLink} from "@angular/router";
import {NzFormModule} from "ng-zorro-antd/form";
import {ToChucRoutingModule} from "./tochuc-routing.module";

@NgModule({
    declarations:[
        ToChucComponent
    ],
    imports: [
        ToChucRoutingModule,
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
        ReactiveFormsModule,
        RouterLink,
        NzFormModule

    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class ToChucModule{}