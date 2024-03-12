import {NgModule} from "@angular/core";
import {ChiTietDeTaiComponent} from "./detail.component";
import {PagingService} from "../../../core/services/paging.service";
import {ChiTietDeTailRoutingModule} from "./detail-routing.module";
import {CommonModule} from "@angular/common";
import {ReactiveFormsModule} from "@angular/forms";

@NgModule({
    declarations:[
        ChiTietDeTaiComponent
    ],
    imports:[
        ChiTietDeTailRoutingModule,
        CommonModule,
        ReactiveFormsModule
    ],
    exports:[

    ],
    providers:[
        PagingService
    ]
})

export class ChiTietDeTailModule{

}