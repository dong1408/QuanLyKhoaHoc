import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {ScoreRoutingModule} from "./score-routing.module";
import {ScoreComponent} from "./score.component";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzModalModule} from "ng-zorro-antd/modal";
import {NzPaginationModule} from "ng-zorro-antd/pagination";
import {NzSelectModule} from "ng-zorro-antd/select";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../../shared/components/shared.module";

@NgModule({
    declarations:[
        ScoreComponent
    ],
    imports: [
        ScoreRoutingModule,
        CommonModule,
        ReactiveFormsModule,
        NzButtonModule,
        NzFormModule,
        NzGridModule,
        NzIconModule,
        NzInputModule,
        NzModalModule,
        NzPaginationModule,
        NzSelectModule,
        NzWaveModule,
        SharedModule
    ],
    exports:[

    ]
})

export class ScoreModule{}