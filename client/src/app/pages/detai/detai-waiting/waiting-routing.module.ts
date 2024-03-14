import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {DeTaiWaitingComponent} from "./waiting.component";


const routes:Routes = [
    {
        path:"",
        component:DeTaiWaitingComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})
export class DeTaiWaitingRoutingModule{

}