import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {HeaderComponent} from "./header/header.component";
import {RecognizeCardComponent} from "./recognize/recognize-card.component";
import {NzDividerModule} from "ng-zorro-antd/divider";
import {ScoreCardComponent} from "./score/score-card.component";
import {LoadingComponent} from "./loading/loading.component";
import {NzSpinModule} from "ng-zorro-antd/spin";
import {RankCardComponent} from "./rank/rank.component";
import {SanPhamComponent} from "./san-pham/san-pham.component";
import {NzTagModule} from "ng-zorro-antd/tag";
import {BaiBaoComponent} from "./bai-bao/bai-bao.component";
import {DeTaiComponent} from "./de-tai/de-tai.component";
import {BaoCaoComponent} from "./bao-cao/bao-cao.component";
import {TrangThaiDeTaiComponent} from "./trang-thai-de-tai/trang-thai-de-tai.component";
import {HuongDanComponent} from "./huong-dan/huong-dan.component";
import {NzButtonModule} from "ng-zorro-antd/button";
import {NzDrawerModule} from "ng-zorro-antd/drawer";
import {NzIconModule} from "ng-zorro-antd/icon";
import {NzWaveModule} from "ng-zorro-antd/core/wave";
import {RouterLink, RouterOutlet} from "@angular/router";
import {NzDescriptionsModule} from "ng-zorro-antd/descriptions";

@NgModule({
    declarations:[ //declare cac component
        HeaderComponent,
        RecognizeCardComponent,
        ScoreCardComponent,
        LoadingComponent,
        RankCardComponent,
        SanPhamComponent,
        BaiBaoComponent,
        DeTaiComponent,
        BaoCaoComponent,
        TrangThaiDeTaiComponent,
        HuongDanComponent
    ],
    imports: [ // import module
        CommonModule,
        NzDividerModule,
        NzSpinModule,
        NzTagModule,
        NzButtonModule,
        NzDrawerModule,
        NzIconModule,
        NzWaveModule,
        RouterOutlet,
        RouterLink,
        NzDescriptionsModule
    ],
    exports:[ //export cac component
        HeaderComponent,
        RecognizeCardComponent,
        ScoreCardComponent,
        LoadingComponent,
        RankCardComponent,
        SanPhamComponent,
        BaiBaoComponent,
        DeTaiComponent,
        BaoCaoComponent,
        TrangThaiDeTaiComponent,
        HuongDanComponent
    ]
})

export class SharedModule{}