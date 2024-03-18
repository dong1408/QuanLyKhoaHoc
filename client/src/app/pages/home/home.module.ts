import {NgModule} from "@angular/core";
import {HomeComponent} from "./home.component";
import {HomeRoutingModule} from "./home-routing.module";
import {SharedModule} from "../../shared/components/shared.module";
import {NzLayoutModule} from "ng-zorro-antd/layout";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDrawerModule} from "ng-zorro-antd/drawer";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NgForOf, NgIf} from "@angular/common";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzInputModule} from "ng-zorro-antd/input";
import {ReactiveFormsModule} from "@angular/forms";

@NgModule({
    declarations:[
        HomeComponent
    ],
    imports: [
        HomeRoutingModule,
        SharedModule,
        NzLayoutModule,
        NzButtonModule,
        NzDrawerModule,
        NzIconModule,
        NzDividerModule,
        NgForOf,
        NgIf,
        NzFormModule,
        NzGridModule,
        NzInputModule,
        ReactiveFormsModule
    ],
    exports:[

    ]
})

export class HomeModule{}