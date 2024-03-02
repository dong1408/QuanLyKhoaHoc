import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {authGuards} from "./core/guards/auth.guards";
import {notAuthGuard} from "./core/guards/not-auth.guards";

const routes: Routes = [
  { path: '',canActivate:[authGuards], loadChildren: () => import('./pages/main/main.module').then(m => m.MainModule) },
  { path: 'dang-nhap',canActivate:[notAuthGuard],loadChildren: () => import('./pages/login/login.module').then(m => m.LoginModule)}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
