import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {BaiBaoWaitingComponent} from "./waiting.component";


const routes:Routes = [
    {
        path:"",
        component:BaiBaoWaitingComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})
export class BaiBaoWaitingRoutingModule{

}