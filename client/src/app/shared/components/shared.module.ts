import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {HeaderComponent} from "./header/header.component";
import {RecognizeCardComponent} from "./recognize/recognize-card.component";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {ScoreCardComponent} from "./score/score-card.component";
import {LoadingComponent} from "./loading/loading.component";
import {NzSpinModule} from "ng-zorro-antd/spin";
import {RankCardComponent} from "./rank/rank.component";

@NgModule({
    declarations:[ //declare cac component
        HeaderComponent,
        RecognizeCardComponent,
        ScoreCardComponent,
        LoadingComponent,
        RankCardComponent
    ],
    imports: [ // import module
        CommonModule,
        NzDividerModule,
        NzSpinModule
    ],
    exports:[ //export cac component
        HeaderComponent,
        RecognizeCardComponent,
        ScoreCardComponent,
        LoadingComponent,
        RankCardComponent
    ]
})

export class SharedModule{}