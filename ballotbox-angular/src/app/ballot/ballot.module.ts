import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BallotRoutingModule }       from './ballot-routing.module';
import { BallotListComponent } from './ballot-list.component';

@NgModule({
  imports: [
    CommonModule,
    BallotRoutingModule
  ],
  declarations: [BallotListComponent]
})
export class BallotModule { }
