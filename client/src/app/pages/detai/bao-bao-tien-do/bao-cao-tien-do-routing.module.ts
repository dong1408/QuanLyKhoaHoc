import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {BaoCaoTienDoComponent} from "./bao-cao-tien-do.component";

const routes:Routes = [
    {
        path:"",
        component:BaoCaoTienDoComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class BaoCaoTienDoRoutingModule{}