import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {MagazineDetailComponent} from "./detail.component";

const routes:Routes = [
    {
        path:"",
        component:MagazineDetailComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class MagazineDetailRoutingModule {}