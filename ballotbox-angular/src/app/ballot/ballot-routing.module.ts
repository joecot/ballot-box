import { NgModule }     from '@angular/core';
import { RouterModule } from '@angular/router';

import { BallotComponent }           from './ballot.component';

@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component: BallotComponent
      }
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class BallotRoutingModule {}