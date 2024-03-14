import {NgModule} from "@angular/core";
import {BaoCaoTienDoComponent} from "./bao-cao-tien-do.component";
import {PagingService} from "../../../core/services/paging.service";
import {BaoCaoTienDoRoutingModule} from "./bao-cao-tien-do-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";

@NgModule({
    declarations:[
      BaoCaoTienDoComponent
    ],
    imports:[
        BaoCaoTienDoRoutingModule,
        CommonModule,
        ReactiveFormsModule
    ],
    providers:[
        PagingService
    ]
})

export class BaoCaoTienDoModule{}