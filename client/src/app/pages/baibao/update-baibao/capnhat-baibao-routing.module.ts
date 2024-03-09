import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {CapNhatBaiBaoComponent} from "./capnhat-baibao.component";

const routes:Routes = [
    {
        path:"",
        component:CapNhatBaiBaoComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class CapNhatBaiBaoRoutingModule{}