"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
require("rxjs/add/operator/toPromise");
var BackendService = (function () {
    function BackendService(http) {
        this.http = http;
        this.resultsUrl = 'api/results.json';
        this.lastResultUrl = 'api/last_result.json';
        this.resultUrl = 'api/result-';
    }
    BackendService.prototype.getResults = function (startDate, endDate) {
        return this.http.get(this.resultsUrl + '#start=' + startDate + ';end=' + endDate)
            .toPromise()
            .then(function (response) { return response.json(); })
            .catch(this.handleError);
    };
    BackendService.prototype.getLastResult = function () {
        return this.http.get(this.lastResultUrl)
            .toPromise()
            .then(function (response) { return response.json(); })
            .catch(this.handleError);
    };
    BackendService.prototype.getResult = function (id) {
        return this.http.get(this.resultUrl + id)
            .toPromise()
            .then(function (response) { return response.json(); })
            .catch(this.handleError);
    };
    BackendService.prototype.handleError = function (error) {
        console.error('An error occurred', error); // for demo purposes only
        return Promise.reject(error.message || error);
    };
    return BackendService;
}());
BackendService = __decorate([
    core_1.Injectable(),
    __metadata("design:paramtypes", [http_1.Http])
], BackendService);
exports.BackendService = BackendService;
//# sourceMappingURL=backend.service.js.map