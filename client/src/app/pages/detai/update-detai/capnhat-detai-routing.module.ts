import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {CapNhatDeTaiComponent} from "./capnhat-detai.component";

const routes:Routes = [
    {
        path:"",
        component:CapNhatDeTaiComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class CapNhatDeTaiRoutingModule{

}