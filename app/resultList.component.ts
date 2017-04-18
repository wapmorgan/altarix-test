import { OnInit, Component, EventEmitter, Input, Output } from '@angular/core';
import { Result } from './result';
import { BackendService } from './backend.service';

@Component({
  selector: 'resultList',
  templateUrl: './resultList.component.html'
})
export class ResultList implements OnInit {
    loading: boolean = true;
    results: Result[] = [];
    @Output() onSelected = new EventEmitter<number>();
    selectedResult: Result;

    private _currentDate: string;
    private _startDate: string;
    private _endDate: string;

    constructor(private backend: BackendService) {}

    ngOnInit(): void {
        this.getResults();
    }

    getResults(): void {
      this.loading = true;
      if (this._startDate != '' && this._endDate != '') {
        console.log('Requesting results ' + this._startDate + ' - ' + this._endDate);
        this.backend.getResults(this._startDate, this._endDate).then(results => this.results = results);
      }
      this.loading = false;
    }

    selectResult(result: Result): void {
      this.selectedResult = result;
      this.onSelected.emit(result.id)
    }

    @Input()
    set currentDate(date: string) { this._currentDate = date; }
    get currentDate(): string { return this._currentDate; }

    @Input()
    set startDate(date: string) {
      if (date != this._startDate) {
        this._startDate = date;
        console.log(this._endDate);
        if (this._endDate != undefined)
          this.getResults();
      }
    }
    get startDate(): string { return this._startDate; }

    @Input()
    set endDate(date: string) {
      if (date != this._endDate) {
        this._endDate = date;
        if (this._startDate != undefined)
          this.getResults();
      }
    }
    get endDate(): string { return this._endDate; }
}
