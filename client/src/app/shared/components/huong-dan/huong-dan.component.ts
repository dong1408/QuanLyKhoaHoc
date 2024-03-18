import {Component, Input} from "@angular/core";

@Component({
    selector:'app-huong-dan-component',
    templateUrl:'./huong-dan.component.html',
    styleUrls:['./huong-dan.component.css']
})

export class HuongDanComponent{
    @Input() huongdan:Array<string> = []
}