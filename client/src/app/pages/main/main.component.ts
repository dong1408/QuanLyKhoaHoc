import {Component, OnDestroy, OnInit} from '@angular/core';
import {User} from "../../core/types/user/user.type";
import {AuthService} from "../../core/services/user/auth.service";
import {Subject, takeUntil} from "rxjs";
import {LocalStorageService} from "../../core/services/local-storage.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {Router} from "@angular/router";

@Component({
  selector: 'app-welcome',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.css']
})
export class MainComponent implements OnInit, OnDestroy {
  isCollapsed = false;

  userInfo: User | null = null

  destroy$: Subject<void> = new Subject<void>()

  logoutLoading:boolean = false

  constructor(
      private authService:AuthService,
      private localStorageService:LocalStorageService,
      private notificationService:NzNotificationService,
      private router:Router
  ) {

  }

  ngOnInit() {
    this.authService.userState$.pipe(takeUntil(this.destroy$)).subscribe(response => {
      console.log(response)
      this.userInfo = response
    })
  }

  logout(){
    this.logoutLoading = true
    this.authService.logout().pipe(
        takeUntil(this.destroy$)
    ).subscribe({
      next:(response) => {
        this.notificationService.create(
            "success",
            "Thành Công",
            response.message
        )
        this.localStorageService.clear()
        this.authService.userState$.next(null)
        this.logoutLoading = false
        window.location.href  = "/dang-nhap"
      },
      error:(error) => {
        this.notificationService.create(
            "error",
            "Lỗi",
            error
        )
      }
    })
  }


  ngOnDestroy() {
    this.destroy$.next()
    this.destroy$.complete()
  }
}
