import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DatepickerModule, TimepickerModule } from 'ng2-bootstrap/ng2-bootstrap';
import { BallotRoutingModule }       from './ballot-routing.module';
import { BallotListComponent } from './ballot-list.component';
import { BallotItemComponent } from './ballot-item.component';
import { BallotHomeComponent } from './ballot-home.component';
import { BallotItemService } from './ballot-item.service';

@NgModule({
  imports: [
    CommonModule,
    DatepickerModule,
    TimepickerModule,
    BallotRoutingModule
  ],
  declarations: [BallotListComponent, BallotItemComponent, BallotHomeComponent],
  providers: [BallotItemService]
})
export class BallotModule { }
