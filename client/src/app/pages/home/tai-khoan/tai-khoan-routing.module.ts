import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {TaiKhoanComponent} from "./tai-khoan.component";

const routes:Routes = [
    {
        path:"",
        component:TaiKhoanComponent,
        children:[
            {
                path:"thong-tin",
                loadChildren: () => import('./user-info/user-info.module').then(m => m.UserInfoModule)
            },
            {
                path:"san-pham/bai-bao",
                loadChildren: () => import('./bai-bao/bai-bao.module').then(m => m.BaiBaoModule)
            },
            {
                path:"san-pham/de-tai",
                loadChildren: () => import('./de-tai/de-tai.module').then(m => m.DeTaiModule)
            }
        ]
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class TaiKhoanRoutingModule{}