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
var backend_service_1 = require("./backend.service");
var ResultList = (function () {
    function ResultList(backend) {
        this.backend = backend;
        this.loading = true;
        this.results = [];
        this.onSelected = new core_1.EventEmitter();
    }
    ResultList.prototype.ngOnInit = function () {
        this.getResults();
    };
    ResultList.prototype.getResults = function () {
        var _this = this;
        this.loading = true;
        if (this._startDate != '' && this._endDate != '') {
            console.log('Requesting results ' + this._startDate + ' - ' + this._endDate);
            this.backend.getResults(this._startDate, this._endDate).then(function (results) { return _this.results = results; });
        }
        this.loading = false;
    };
    ResultList.prototype.selectResult = function (result) {
        this.selectedResult = result;
        this.onSelected.emit(result.id);
    };
    Object.defineProperty(ResultList.prototype, "currentDate", {
        get: function () { return this._currentDate; },
        set: function (date) { this._currentDate = date; },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ResultList.prototype, "startDate", {
        get: function () { return this._startDate; },
        set: function (date) {
            if (date != this._startDate) {
                this._startDate = date;
                console.log(this._endDate);
                if (this._endDate != undefined)
                    this.getResults();
            }
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ResultList.prototype, "endDate", {
        get: function () { return this._endDate; },
        set: function (date) {
            if (date != this._endDate) {
                this._endDate = date;
                if (this._startDate != undefined)
                    this.getResults();
            }
        },
        enumerable: true,
        configurable: true
    });
    return ResultList;
}());
__decorate([
    core_1.Output(),
    __metadata("design:type", Object)
], ResultList.prototype, "onSelected", void 0);
__decorate([
    core_1.Input(),
    __metadata("design:type", String),
    __metadata("design:paramtypes", [String])
], ResultList.prototype, "currentDate", null);
__decorate([
    core_1.Input(),
    __metadata("design:type", String),
    __metadata("design:paramtypes", [String])
], ResultList.prototype, "startDate", null);
__decorate([
    core_1.Input(),
    __metadata("design:type", String),
    __metadata("design:paramtypes", [String])
], ResultList.prototype, "endDate", null);
ResultList = __decorate([
    core_1.Component({
        selector: 'resultList',
        templateUrl: './resultList.component.html'
    }),
    __metadata("design:paramtypes", [backend_service_1.BackendService])
], ResultList);
exports.ResultList = ResultList;
//# sourceMappingURL=resultList.component.js.map