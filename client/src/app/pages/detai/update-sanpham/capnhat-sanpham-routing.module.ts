import {NgModule} from "@angular/core";
import {RouterModule, Routes} from "@angular/router";
import {CapNhatSanPhamDeTaiComponent} from "./capnhat-sanpham.component";

const routes:Routes = [
    {
        path:"",
        component:CapNhatSanPhamDeTaiComponent
    }
]

@NgModule({
    imports:[RouterModule.forChild(routes)],
    exports:[RouterModule]
})

export class CapNhatSanPhamDeTaiRoutingModule {}