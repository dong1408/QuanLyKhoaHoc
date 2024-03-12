import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {CapNhatSanPhamBaiBaoComponent} from "./capnhat-sanpham.component";

const routes:Routes = [
    {
        path:"",
        component:CapNhatSanPhamBaiBaoComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class CapNhatSanPhamBaiBaoRoutingModule {}