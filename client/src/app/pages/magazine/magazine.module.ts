import {NgModule} from "@angular/core";
import {MagazineComponent} from "./magazine.component";
import {MagazineRoutingModule} from "./magazine-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {IconsProviderModule} from "../../icons-provider.module";
import {NzTableModule} from "ng-zorro-antd/table";
import {CommonModule} from "@angular/common";
import {NzPopconfirmModule} from "ng-zorro-antd/popconfirm";
import {NzPaginationModule} from "ng-zorro-antd/pagination";

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
        NzPaginationModule
    ],
    exports:[

    ]
})

export class MagazineModule{}