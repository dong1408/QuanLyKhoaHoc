import {NgModule} from "@angular/core";
import {BaiBaoComponent} from "./baibao.component";
import {BaiBaoRoutingModule} from "./baibao-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {IconsProviderModule} from "../../icons-provider.module";
import {NzTableModule} from "ng-zorro-antd/table";
import {CommonModule} from "@angular/common";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzInputModule} from "ng-zorro-antd/input";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NzSelectModule} from "ng-zorro-antd/select";
import {PagingServiceFactory} from "../../core/services/paging-service.factory";
import {PagingService} from "../../core/services/paging.service";

@NgModule({
    declarations:[
        BaiBaoComponent
    ],
    imports: [
        BaiBaoRoutingModule,
        NzButtonModule,
        IconsProviderModule,
        NzTableModule,
        CommonModule,
        NzPopconfirmModule,
        NzPaginationModule,
        NzInputModule,
        FormsModule,
        NzSelectModule,
        ReactiveFormsModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class BaibaoModule {}