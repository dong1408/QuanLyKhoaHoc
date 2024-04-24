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
                path:"san-pham/bai-bao/:id/cap-nhat",
                loadChildren: () => import('./bai-bao/update-baibao/capnhat-baibao.module').then(m => m.CapNhatBaiBaoModule)
            },
            {
                path:"san-pham/bai-bao/tao-moi",
                loadChildren: () => import('./bai-bao/create/create.module').then(m => m.BaiBaoCreateModule)
            },
            {
                path:"san-pham/bai-bao/:id",
                loadChildren: () => import('./bai-bao/detail/detail.module').then(m => m.ChiTietBaiBaoModule)
            },
            {
                path:"san-pham/de-tai",
                loadChildren: () => import('./de-tai/de-tai.module').then(m => m.DeTaiModule)
            },
            //
            {
                path:"san-pham/de-tai/:id/cap-nhat",
                loadChildren: () => import('./de-tai/update-detai/capnhat-detai.module').then(m => m.CapNhatDeTaiModule)
            },
            {
                path:"san-pham/de-tai/tao-moi",
                loadChildren: () => import('./de-tai/create/create.module').then(m => m.TaoDeTaiModule)
            },
            {
                path:"san-pham/de-tai/:id",
                loadChildren: () => import('./de-tai/detail/detail.module').then(m => m.ChiTietDeTaiModule)
            },
        ]
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class TaiKhoanRoutingModule{}