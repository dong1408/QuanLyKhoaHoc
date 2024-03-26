import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {MagazineUpdateComponent} from "./update.component";

const routes:Routes = [
    {
        path:"",
        component:MagazineUpdateComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class MagazineUpdateRoutingModule{}