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
var AppComponent = (function () {
    function AppComponent(backend) {
        this.backend = backend;
    }
    AppComponent.prototype.ngOnInit = function () {
        this.getLastResult();
        var date = new Date();
        this.currentDate = date.getFullYear() + '-' + (date.getMonth() < 9 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-' + (date.getDate() < 10 ? '0' + date.getDate() : date.getDate());
        this.startDate = this.currentDate;
        this.endDate = this.startDate;
    };
    AppComponent.prototype.getLastResult = function () {
        var _this = this;
        this.backend.getLastResult().then(function (lastResult) { return _this.lastResult = lastResult; });
    };
    AppComponent.prototype.onSelected = function (id) {
        var _this = this;
        this.backend.getResult(id).then(function (selectedResult) { return _this.selectedResult = selectedResult; });
    };
    AppComponent.prototype.startDateChange = function (date) {
        this.startDate = date;
    };
    AppComponent.prototype.endDateChange = function (date) {
        this.endDate = date;
    };
    return AppComponent;
}());
AppComponent = __decorate([
    core_1.Component({
        selector: 'my-app',
        templateUrl: './app.component.html'
    }),
    __metadata("design:paramtypes", [backend_service_1.BackendService])
], AppComponent);
exports.AppComponent = AppComponent;
//# sourceMappingURL=app.component.js.map