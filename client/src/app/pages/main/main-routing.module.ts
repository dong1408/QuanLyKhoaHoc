import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { MainComponent } from './main.component';
import {MagazineComponent} from "../magazine/magazine.component";
import {BaiBaoWaitingModule} from "../baibao/baibao-waiting/waiting.module";

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
      }
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MainRoutingModule { }
