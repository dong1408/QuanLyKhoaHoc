import {Component, OnDestroy, OnInit} from "@angular/core";
import {Me} from "../../core/types/user/user.type";
import {Subject, takeUntil} from "rxjs";
import {AuthService} from "../../core/services/user/auth.service";
import {LocalStorageService} from "../../core/services/local-storage.service";
import {NzNotificationService} from "ng-zorro-antd/notification";
import {Router} from "@angular/router";
import {ConstantsService} from "../../core/services/constants.service";

@Component({
    selector:'app-home-component',
    templateUrl:'./home.component.html',
    styleUrls:['./home.component.css']
})

export class HomeComponent{

}
