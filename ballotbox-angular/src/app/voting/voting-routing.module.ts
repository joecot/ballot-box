import { NgModule }     from '@angular/core';
import { RouterModule } from '@angular/router';

import { VotingComponent }           from './voting.component';

@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component: VotingComponent
      }
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class VotingRoutingModule {}