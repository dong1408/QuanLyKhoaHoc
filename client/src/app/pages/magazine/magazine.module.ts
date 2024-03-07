import {NgModule} from "@angular/core";
import {MagazineComponent} from "./magazine.component";
import {MagazineRoutingModule} from "./magazine-routing.module";
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
        MagazineComponent
    ],
    imports: [
        MagazineRoutingModule,
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
        PagingServiceFactory,
        PagingService
    ]
})

export class MagazineModule{}