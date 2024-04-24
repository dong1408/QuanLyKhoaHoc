import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {DeTaiComponent} from "./de-tai.component";

const routes:Routes = [
    {
        path:"",
        component:DeTaiComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class DeTaiRoutingModule {}