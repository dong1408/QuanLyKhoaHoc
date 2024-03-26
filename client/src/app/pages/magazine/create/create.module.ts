import {NgModule} from "@angular/core";
import {MagazineCreateComponent} from "./create.component";
import {CommonModule} from "@angular/common";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {MagazineCreateRoutingModule} from "./create-routing.module";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzSelectModule} from "ng-zorro-antd/select";
import {SharedModule} from "../../../shared/components/shared.module";

@NgModule({
    declarations:[
        MagazineCreateComponent
    ],
    imports: [
        CommonModule,
        ReactiveFormsModule,
        MagazineCreateRoutingModule,
        NzButtonModule,
        NzIconModule,
        NzWaveModule,
        NzFormModule,
        NzGridModule,
        NzInputModule,
        NzSelectModule,
        FormsModule,
        SharedModule
    ],
    exports:[

    ]
})

export class MagazineCreateModule{}