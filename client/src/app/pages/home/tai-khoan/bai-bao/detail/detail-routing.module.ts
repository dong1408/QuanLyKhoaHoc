import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {ChiTietBaiBaoComponent} from "./detail.component";

const routes:Routes = [
    {
        path:"",
        component:ChiTietBaiBaoComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class ChiTietBaiBaoRoutingModule{}