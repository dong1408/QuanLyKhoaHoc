import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {CapNhatToChucComponent} from "./update.component";


const routes:Routes = [
    {
        path:"",
        component:CapNhatToChucComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class CapNhatToChucRoutingModule{}