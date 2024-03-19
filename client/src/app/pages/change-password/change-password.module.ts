import {NgModule} from "@angular/core";
import {ChangePasswordComponent} from "./change-password.component";
import {ChangePasswordRoutingModule} from "./change-password-routing.module";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NgIf} from "@angular/common";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";
import {NzGridModule} from "ng-zorro-antd/grid";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {SharedModule} from "../../shared/components/shared.module";

@NgModule({
    declarations:[
        ChangePasswordComponent
    ],
    imports: [
        ChangePasswordRoutingModule,
        FormsModule,
        NgIf,
        NzButtonModule,
        NzDividerModule,
        NzFormModule,
        NzGridModule,
        NzInputModule,
        NzWaveModule,
        ReactiveFormsModule,
        SharedModule
    ],
    exports:[

    ]
})

export class ChangePasswordModule{}