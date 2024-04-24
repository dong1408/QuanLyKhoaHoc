import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {TaoToChucComponent} from "./create.component";


const routes:Routes = [
    {
        path:"",
        component:TaoToChucComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class TaoToChucRoutingModule{}