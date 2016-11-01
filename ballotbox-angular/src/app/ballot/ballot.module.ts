import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BallotRoutingModule }       from './ballot-routing.module';
import { BallotComponent } from './ballot.component';

@NgModule({
  imports: [
    CommonModule,
    BallotRoutingModule
  ],
  declarations: [BallotComponent]
})
export class BallotModule { }
