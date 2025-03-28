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
        path:`tap-chi/:id/cap-nhat`,
        loadChildren: () => import('../magazine/update/update.module').then(m => m.MagazineUpdateModule)
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
      },
      {
        path:"bai-bao/tao-moi",
        loadChildren:() => import('../baibao/create/create.module').then(m => m.BaiBaoCreateModule)
      },
      {
        path:"bai-bao/:id",
        loadChildren:() => import('../baibao/detail/detail.module').then(m => m.ChiTietBaiBaoModule)
      },
      {
        path:"de-tai",
        loadChildren:() => import('../detai/detai.module').then(m => m.DeTaiModule)
      },
      {
        path:"de-tai/cho-phe-duyet",
        loadChildren:() => import('../detai/detai-waiting/waiting.module').then(m => m.DeTaiWaitingModule)
      },
      {
        path:"de-tai/:id/thong-tin-san-pham",
        loadChildren:() => import('../detai/update-sanpham/capnhat-sanpham.module').then(m => m.CapNhatSanPhamDeTaiModule)
      },
      {
        path:"de-tai/:id/thong-tin-de-tai",
        loadChildren:() => import('../detai/update-detai/capnhat-detai.module').then(m => m.CapNhatDeTaiModule)
      },
      {
        path:"de-tai/:id/bao-cao-tien-do",
        loadChildren:() => import('../detai/bao-bao-tien-do/bao-cao-tien-do.module').then(m => m.BaoCaoTienDoModule)
      },
      {
        path:"de-tai/tao-moi",
        loadChildren:() => import('../detai/create/create.module').then(m => m.TaoDeTaiModule)
      },
      {
        path:"de-tai/:id",
        loadChildren:() => import('../detai/detail/detail.module').then(m => m.ChiTietDeTaiModule)
      },
      {
        path:"nguoi-dung",
        loadChildren:() => import('../user/user.module').then(m => m.UserModule)
      },
      {
        path:"nguoi-dung/tao-moi",
        loadChildren:() => import('../user/create/create.module').then(m => m.UserCreateModule)
      },
      {
        path:"nguoi-dung/:id/cap-nhat-nguoi-dung",
        loadChildren:() => import('../user/update/update.module').then(m => m.UserUpdateModule)
      },
      {
        path:"vai-tro",
        loadChildren:() => import('../role/role.module').then(m => m.RoleModule)
      },
      {
        path:"vai-tro/tao-moi",
        loadChildren:() => import('../role/create/create.module').then(m => m.CreateRoleModule)
      },
      {
        path:"vai-tro/:id/cap-nhat-vai-tro",
        loadChildren:() => import('../role/update/update.module').then(m => m.UpdateRoleModule)
      },

      {
        path:"to-chuc",
        loadChildren:() => import('../tochuc/tochuc.module').then(m => m.ToChucModule)
      },

      {
        path:"to-chuc/tao-moi",
        loadChildren:() => import('../tochuc/create/create.module').then(m => m.TaoToChucModule)
      },
      {
        path:"to-chuc/:id",
        loadChildren:() => import('../tochuc/update/update.module').then(m => m.CapNhatToChucModule)
      },
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MainRoutingModule { }
