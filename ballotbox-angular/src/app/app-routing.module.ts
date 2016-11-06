import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
@NgModule({
  imports: [
    RouterModule.forRoot([
    	{ path: '', redirectTo: 'voting', pathMatch: 'full'},
    	{ path: 'voting', loadChildren: 'app/voting/voting.module#VotingModule'},
    	{ path: 'ballot', loadChildren: 'app/ballot/ballot.module#BallotModule'},
    ])
  ],
  exports: [
    RouterModule
  ],
  providers: [
    
  ]
})
export class AppRoutingModule {}