import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {UserUpdateComponent} from "./update.component";

const routes:Routes = [
    {
        path:"",
        component:UserUpdateComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class UserUpdateRoutingModule{}