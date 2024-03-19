import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./home.component";
import {notChangedGuards} from "../../core/guards/not-changed.guards";

const routes:Routes = [
    {
        path:"",
        component:HomeComponent,
        children:[
            {
                path:"tai-khoan",
                loadChildren: () => import('./tai-khoan/tai-khoan.module').then(m => m.TaiKhoanModule)
            },
            {
                path: 'doi-mat-khau',
                // canActivate:[notChangedGuards],
                loadChildren: () => import('./change-password/change-password.module').then(m => m.ChangePasswordModule)
            },
        ]
    },
]


@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class HomeRoutingModule{}