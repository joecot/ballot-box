import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ResultsRoutingModule }       from './results-routing.module';
import { ResultsComponent } from './results.component';

@NgModule({
  imports: [
    CommonModule,
    ResultsRoutingModule
  ],
  declarations: [ResultsComponent]
})
export class ResultsModule { }
