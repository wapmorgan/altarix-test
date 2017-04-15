import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpModule } from '@angular/http';

import { AppComponent }  from './app.component';
import { ResultList }  from './resultList.component';
import { BackendService }  from './backend.service';

@NgModule({
  imports:      [
    BrowserModule,
    HttpModule
  ],
  declarations: [
      AppComponent,
      ResultList
  ],
  bootstrap:    [ AppComponent ],
  providers:     [
      BackendService
  ]
})
export class AppModule { }
