import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {ChiTietDeTaiComponent} from "./detail.component";

const routes:Routes = [
    {
        path:"",
        component:ChiTietDeTaiComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class ChiTietDeTailRoutingModule{}