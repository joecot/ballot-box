import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { BallotRoutingModule }       from './ballot-routing.module';
import { BallotListComponent } from './ballot-list.component';
import { BallotItemComponent } from './ballot-item.component';
import { BallotHomeComponent } from './ballot-home.component';
import { BallotItemService } from './ballot-item.service';

@NgModule({
  imports: [
    CommonModule,
    BallotRoutingModule
  ],
  declarations: [BallotListComponent, BallotItemComponent, BallotHomeComponent],
  providers: [BallotItemService]
})
export class BallotModule { }
