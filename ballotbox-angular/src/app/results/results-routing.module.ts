import { NgModule }     from '@angular/core';
import { RouterModule } from '@angular/router';

import { ResultsComponent }           from './results.component';

@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component: ResultsComponent
      }
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class ResultsRoutingModule {}