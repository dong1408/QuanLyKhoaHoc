import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {RecognizeComponent} from "./recognize.component";

const routes:Routes = [
    {
        path:"",
        component:RecognizeComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class RecognizeRoutingModule {

}