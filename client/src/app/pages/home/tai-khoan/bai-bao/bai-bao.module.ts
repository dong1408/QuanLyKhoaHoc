import {NgModule} from "@angular/core";
import {BaiBaoComponent} from "./bai-bao.component";
import {BaiBaoRoutingModule} from "./bai-bao-routing.module";
import {PagingService} from "../../../../core/services/paging.service";
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
import {NzFormModule} from "ng-zorro-antd/form";
import {NzTabsModule} from "ng-zorro-antd/tabs";

@NgModule({
    declarations:[
        BaiBaoComponent
    ],
    imports: [
        BaiBaoRoutingModule,
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
        NzFormModule,
        NzTabsModule
    ],
    exports:[

    ],
    providers:[
        {
            provide:'paging1',
            useClass:PagingService
        },
        {
            provide:'paging2',
            useClass:PagingService
        },
    ]
})

export class BaiBaoModule{}