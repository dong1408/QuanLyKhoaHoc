import { NgModule } from '@angular/core';
import { MainRoutingModule } from './main-routing.module';
import { MainComponent } from './main.component';
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzLayoutModule} from "ng-zorro-antd/layout";
import {NzMenuModule} from "ng-zorro-antd/menu";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzWaveModule} from "ng-zorro-antd/core/wave";


@NgModule({
    imports: [
        MainRoutingModule,
        NzIconModule,
        NzLayoutModule,
        NzMenuModule,
        NzButtonModule,
        NzWaveModule,
    ],
  declarations: [
      MainComponent
  ],
  exports: [
      MainComponent
  ]
})
export class MainModule { }
