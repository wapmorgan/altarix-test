import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';
import { Result } from './result';

import 'rxjs/add/operator/toPromise';

@Injectable()
export class BackendService {
    private resultsUrl = 'api/results.json';
    private lastResultUrl = 'api/last_result.json';
    private resultUrl = 'api/result-';

    constructor(private http: Http) { }

    getResults(): Promise<Result[]> {
        return this.http.get(this.resultsUrl)
           .toPromise()
           .then(response => response.json() as Result[])
           .catch(this.handleError);
    }

    getLastResult(): Promise<Result> {
        return this.http.get(this.lastResultUrl)
           .toPromise()
           .then(response => response.json() as Result)
           .catch(this.handleError);
    }

    getResult(id: number): Promise<Result> {
        return this.http.get(this.resultUrl + id)
           .toPromise()
           .then(response => response.json() as Result)
           .catch(this.handleError);
    }

    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error); // for demo purposes only
        return Promise.reject(error.message || error);
    }
}