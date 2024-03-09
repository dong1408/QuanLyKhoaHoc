import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { MainComponent } from './main.component';
import {MagazineComponent} from "../magazine/magazine.component";
import {BaiBaoWaitingModule} from "../baibao/baibao-waiting/waiting.module";
import {CapNhatBaiBaoModule} from "../baibao/update-baibao/capnhat-baibao.module";

const routes: Routes = [
  {
    path: '',
    component: MainComponent,
    children:[
      {
          path:"tap-chi",
          loadChildren: () => import('../magazine/magazine.module').then(m => m.MagazineModule)
      },
      {
        path:"tap-chi/tao-moi",
        loadChildren: () => import('../magazine/create/create.module').then(m => m.MagazineCreateModule)
      },
      {
        path:"tap-chi/cho-phe-duyet",
        loadChildren: () => import('../magazine/magazine-waiting/waiting.module').then(m => m.MagazineWaitingModule)
      },
      {
        path:`tap-chi/:id/lich-su-cong-nhan`,
        loadChildren: () => import('../magazine/recognize/recognize.module').then(m => m.RecognizeModule)
      },
      {
        path:"tap-chi/:id/lich-su-tinh-diem",
        loadChildren: () => import('../magazine/score/score.module').then(m => m.ScoreModule)
      },
      {
        path:"tap-chi/:id/lich-su-xep-hang",
        loadChildren: () => import('../magazine/rank/rank.module').then(m => m.RankModule)
      },
      {
        path:"tap-chi/:id",
        loadChildren: () => import('../magazine/detail/detail.module').then(m => m.MagazineDetailModule)
      },
      {
        path:"bai-bao",
        loadChildren:() => import('../baibao/baibao.module').then(m => m.BaibaoModule)
      },
      {
        path:"bai-bao/cho-phe-duyet",
        loadChildren:() => import('../baibao/baibao-waiting/waiting.module').then(m => m.BaiBaoWaitingModule)
      },
      {
        path:"bai-bao/:id/thong-tin-bai-bao",
        loadChildren:() => import('../baibao/update-baibao/capnhat-baibao.module').then(m => m.CapNhatBaiBaoModule)
      },
      {
        path:"bai-bao/:id/thong-tin-san-pham",
        loadChildren:() => import('../baibao/update-sanpham/capnhat-sanpham.module').then(m => m.CapNhatSanPhamBaiBaoModule)
      }
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MainRoutingModule { }
