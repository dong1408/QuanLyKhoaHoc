import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {MagazineCreateComponent} from "./create.component";

const routes:Routes = [
    {
        path:"",
        component:MagazineCreateComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class MagazineCreateRoutingModule{}