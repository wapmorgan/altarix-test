import { OnInit } from '@angular/core'
import { Component } from '@angular/core'
import * as moment from 'moment'
import { BackendService } from './backend.service'
import { Result } from './result'

@Component({
  selector: 'my-app',
  templateUrl: './app.component.html'
})
export class AppComponent {
    lastResult: Result;
    selectedResult: Result;
    startDate: string;
    endDate: string;

    constructor (private backend: BackendService) {}

    ngOnInit(): void {
        this.getLastResult();
        this.startDate = moment().format('DDD.MM.YYYY');
        this.endDate = this.startDate;
        console.log(this.startDate);
    }

    getLastResult(): void {
        this.backend.getLastResult().then(lastResult => this.lastResult = lastResult);
    }

    onSelected(id: number): void {
        this.backend.getResult(id).then(selectedResult => this.selectedResult = selectedResult);
        console.log(id);
        this.startDate = moment().format('DDD.MM.YYYY');
        this.endDate = this.startDate;
        console.log(this.startDate);
    }
}
