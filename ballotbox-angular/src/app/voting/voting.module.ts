import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { VotingRoutingModule }       from './voting-routing.module';

import { VotingComponent } from './voting.component';

@NgModule({
  imports: [
    CommonModule,
    VotingRoutingModule
  ],
  declarations: [VotingComponent],
  bootstrap: []
})
export class VotingModule {
  constructor(){
    console.log('voting constructor called');
  }
  
}
