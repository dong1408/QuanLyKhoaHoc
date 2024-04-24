import {APP_INITIALIZER, NgModule} from '@angular/core';
import {Routes, RouterModule, PreloadAllModules, Router} from '@angular/router';
import {authGuards} from "./core/guards/auth.guards";
import {notAuthGuard} from "./core/guards/not-auth.guards";
import {notChangedGuards} from "./core/guards/not-changed.guards";
import {AuthService} from "./core/services/user/auth.service";
import {LocalStorageService} from "./core/services/local-storage.service";
import {ACCESS_TOKEN, REFRESH_TOKEN} from "./shared/commons/constants";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {adminGuards} from "./core/guards/admin.guards";

const routes: Routes = [
    {
        path: "",
        redirectTo: "/home",
        pathMatch: "full"
    },
  {
      path: 'admin',
      canActivate:[adminGuards],
      loadChildren: () => import('./pages/main/main.module').then(m => m.MainModule)
  },
  {
      path: 'dang-nhap',
      canActivate:[notAuthGuard],
      loadChildren: () => import('./pages/login/login.module').then(m => m.LoginModule)
  },
  {
      path: 'home',
      canActivate:[authGuards],
      loadChildren: () => import('./pages/home/home.module').then(m => m.HomeModule)
  },
    {
        path: 'doi-mat-khau',
        canActivate:[notChangedGuards],
        loadChildren: () => import('./pages/change-password/change-password.module').then(m => m.ChangePasswordModule)
    }
];

@NgModule({
  imports: [
      RouterModule.forRoot(
          routes,
          {
            preloadingStrategy: PreloadAllModules // ky thuat preloading, load cac bundle o bg
          }
      )
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
