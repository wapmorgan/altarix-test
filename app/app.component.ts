import { OnInit } from '@angular/core'
import { Component } from '@angular/core'
import moment from 'moment'
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
    currentDate: string;

    constructor (private backend: BackendService) {}

    ngOnInit(): void {
        this.getLastResult();
        var date: Date = new Date();
        this.currentDate = date.getFullYear() + '-' + (date.getMonth() < 9 ? '0' + (date.getMonth()+1) : date.getMonth()+1) + '-' + (date.getDate() < 10 ? '0' + date.getDate() : date.getDate());
        this.startDate = this.currentDate;
        this.endDate = this.startDate;
        console.log(this.startDate);
    }

    getLastResult(): void {
        this.backend.getLastResult().then(lastResult => this.lastResult = lastResult);
    }

    onSelected(id: number): void {
        this.backend.getResult(id).then(selectedResult => this.selectedResult = selectedResult);
        console.log(id);
    }


    startDateChange(date: string): void {
        this.startDate = date;
    }

    endDateChange(date: string): void {
        this.endDate = date;
    }
}
