import {Component, OnInit} from '@angular/core';
import {AuthService} from "./core/services/user/auth.service";
import {LocalStorageService} from "./core/services/local-storage.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {Router} from "@angular/router";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit{
  constructor(
      private authService:AuthService,
      private localStorageService:LocalStorageService,
      private notificationService:NzNotificationService,
      private router:Router
  ){

  }

  ngOnInit() {
    // if(this.localStorageService.get(ACCESS_TOKEN) !== null && this.localStorageService.get(REFRESH_TOKEN) !== null && this.authService.getCurrentUser() === null){
    //   this.authService.getMe().pipe().subscribe({
    //     next:(response) => {
    //       this.authService.setCurrentUser(response.data)
    //       this.authService.userState$.next(response.data)
    //       if(!response.data.changed){
    //         this.router.navigate(["/doi-mat-khau"])
    //         return;
    //       }
    //     },
    //     error:(error) => {
    //       this.notificationService.create(
    //           'error',
    //           "Lỗi",
    //           error
    //       )
    //       this.router.navigate(["/dang-nhap"])
    //     }
    //   })
    // }
  }
}
