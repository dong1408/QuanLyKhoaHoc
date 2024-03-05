import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { MainComponent } from './main.component';
import {MagazineComponent} from "../magazine/magazine.component";

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
        path:"tap-chi/lich-su-cong-nhan",
        loadChildren: () => import('../magazine/recognize/recognize.module').then(m => m.RecognizeModule)
      },
      {
        path:"tap-chi/lich-su-tinh-diem",
        loadChildren: () => import('../magazine/score/score.module').then(m => m.ScoreModule)
      }
    ]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MainRoutingModule { }
