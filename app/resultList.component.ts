import { OnInit, Component, EventEmitter, Output } from '@angular/core';
import { Result } from './result';
import { BackendService } from './backend.service';

@Component({
  selector: 'resultList',
  templateUrl: './resultList.component.html'
})
export class ResultList implements OnInit {
    results: Result[] = [];
    @Output() onSelected = new EventEmitter<number>();
    selectedResult: Result;

    constructor(private backend: BackendService) {}

    ngOnInit(): void {
        this.getResults();
    }

    getResults(): void {
        this.backend.getResults().then(results => this.results = results);
    }

    selectResult(result: Result): void {
      this.selectedResult = result;
      console.log(result);
      this.onSelected.emit(result.id)
    }
}
