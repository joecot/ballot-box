import { NgModule }     from '@angular/core';
import { RouterModule } from '@angular/router';

import { BallotListComponent }           from './ballot-list.component';
import { BallotHomeComponent } from './ballot-home.component';
import { BallotItemComponent } from './ballot-item.component';
import { BallotItemService } from './ballot-item.service';

@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component: BallotListComponent,
        children: [
        {
          path: '',
          component: BallotHomeComponent
        },
        {
          path: ':id',
          component: BallotItemComponent,
        }]
      }
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class BallotRoutingModule {}