import { NgModule }     from '@angular/core';
import { RouterModule } from '@angular/router';

import { BallotListComponent }           from './ballot-list.component';

@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component: BallotListComponent
      }
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class BallotRoutingModule {}