import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {ToChucComponent} from "./tochuc.component";

const routes:Routes = [
    {
        path:"",
        component:ToChucComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})
export class ToChucRoutingModule{}