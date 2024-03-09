import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {BaiBaoComponent} from "./baibao.component";

const routes:Routes = [
    {
        path:"",
        component:BaiBaoComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class BaiBaoRoutingModule {}