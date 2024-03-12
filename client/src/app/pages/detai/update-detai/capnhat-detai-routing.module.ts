import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {CapNhatDeTailComponent} from "./capnhat-detai.component";

const routes:Routes = [
    {
        path:"",
        component:CapNhatDeTailComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class CapNhatDeTaiRoutingModule{

}