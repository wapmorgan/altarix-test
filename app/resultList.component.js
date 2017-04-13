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
        this.results = [];
        this.onSelected = new core_1.EventEmitter();
    }
    ResultList.prototype.ngOnInit = function () {
        this.getResults();
    };
    ResultList.prototype.getResults = function () {
        var _this = this;
        this.backend.getResults().then(function (results) { return _this.results = results; });
    };
    ResultList.prototype.selectResult = function (result) {
        this.selectedResult = result;
        console.log(result);
        this.onSelected.emit(result.id);
    };
    return ResultList;
}());
__decorate([
    core_1.Output(),
    __metadata("design:type", Object)
], ResultList.prototype, "onSelected", void 0);
ResultList = __decorate([
    core_1.Component({
        selector: 'resultList',
        templateUrl: './resultList.component.html'
    }),
    __metadata("design:paramtypes", [backend_service_1.BackendService])
], ResultList);
exports.ResultList = ResultList;
//# sourceMappingURL=resultList.component.js.map