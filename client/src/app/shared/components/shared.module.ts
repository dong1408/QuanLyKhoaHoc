import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {HeaderComponent} from "./header/header.component";
import {RecognizeCardComponent} from "./recognize/recognize-card.component";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {ScoreCardComponent} from "./score/score-card.component";

@NgModule({
    declarations:[ //declare cac component
        HeaderComponent,
        RecognizeCardComponent,
        ScoreCardComponent
    ],
    imports: [ // import module
        CommonModule,
        NzDividerModule
    ],
    exports:[ //export cac component
        HeaderComponent,
        RecognizeCardComponent,
        ScoreCardComponent
    ]
})

export class SharedModule{}