import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {UpdateRoleComponent} from "./update.component";

const routes:Routes = [
    {
        path:"",
        component:UpdateRoleComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class UpdateRoleRoutingModule {}