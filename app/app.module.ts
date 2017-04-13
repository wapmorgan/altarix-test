import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpModule } from '@angular/http';

import { AppComponent }  from './app.component';
import { DateSelector }  from './dateSelector.component';
import { ResultDetail }  from './resultDetail.component';
import { ResultList }  from './resultList.component';
import { BackendService }  from './backend.service';

@NgModule({
  imports:      [
    BrowserModule,
    HttpModule
  ],
  declarations: [
      AppComponent,
      DateSelector,
      ResultDetail,
      ResultList
  ],
  bootstrap:    [ AppComponent ],
  providers:     [
      BackendService
  ]
})
export class AppModule { }
