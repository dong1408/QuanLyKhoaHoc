import {NgModule} from "@angular/core";
import {LoginComponent} from "./login.component";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";
import {SharedModule} from "../../shared/components/shared.module";
import {LoginRoutingModule} from "./login-routing.module";
import {NzInputModule} from "ng-zorro-antd/input";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {NzFormModule} from "ng-zorro-antd/form";

@NgModule({
    declarations: [
        LoginComponent
    ],
    imports: [
        CommonModule,
        ReactiveFormsModule,
        SharedModule,
        LoginRoutingModule,
        NzInputModule,
        NzButtonModule,
        NzDividerModule,
        NzFormModule
    ],
    exports:[
        LoginComponent
    ]
})

export class LoginModule{}