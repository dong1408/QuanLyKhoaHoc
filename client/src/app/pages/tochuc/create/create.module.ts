import {NgModule} from "@angular/core";
import {TaoToChucComponent} from "./create.component";
import {TaoToChucRoutingModule} from "./create-routing.module";
import {AsyncPipe, NgForOf, NgIf} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../../shared/components/shared.module";

@NgModule({
    declarations:[
        TaoToChucComponent
    ],
    imports: [
        TaoToChucRoutingModule,
        AsyncPipe,
        FormsModule,
        NgForOf,
        NgIf,
        NzButtonModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzSelectModule,
        NzWaveModule,
        ReactiveFormsModule,
        SharedModule
    ],
    exports:[

    ],
})

export class TaoToChucModule{}