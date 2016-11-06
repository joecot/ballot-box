import { NgModule, ModuleWithProviders } from '@angular/core';
import { CommonModule } from '@angular/common';
import {UserService} from './user.service';
import {BallotService} from './ballot.service';

@NgModule({
  imports: [
    CommonModule
  ],
  exports: [ ],
  declarations: [],
  providers: [UserService,BallotService]
})
export class CoreModule {
  /*
  static forRoot(): ModuleWithProviders {
    return {
      ngModule: CoreModule,
      providers: [
        {provide: UserService }
      ]
    };
  }
  */
}
