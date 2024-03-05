import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";
import {HeaderComponent} from "./header/header.component";

@NgModule({
    declarations:[ //declare cac component
        HeaderComponent
    ],
    imports:[ // import module
        CommonModule
    ],
    exports:[ //export cac component
        HeaderComponent
    ]
})

export class SharedModule{}