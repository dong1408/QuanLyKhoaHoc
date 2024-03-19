import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {BaiBaoCreateComponent} from "./create.component";

const routes:Routes = [
    {
        path:"",
        component:BaiBaoCreateComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class BaiBaoCreateRoutingModule{}