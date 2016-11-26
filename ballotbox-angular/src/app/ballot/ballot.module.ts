import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DatepickerModule, TimepickerModule } from 'ng2-bootstrap/ng2-bootstrap';
import { BallotRoutingModule }       from './ballot-routing.module';
import { BallotListComponent } from './ballot-list.component';
import { BallotItemComponent } from './ballot-item.component';
import { BallotHomeComponent } from './ballot-home.component';
import { BallotItemService } from './ballot-item.service';
import { QuestionComponent } from './question/question.component';
import { QuestionsComponent } from './question/questions.component';
import { CandidateComponent } from './candidate/candidate.component';
import { CandidatesComponent } from './candidate/candidates.component';
import { VoterComponent } from './voter/voter.component';
import { VotersComponent } from './voter/voters.component';


@NgModule({
  imports: [
    CommonModule,
    DatepickerModule,
    TimepickerModule,
    BallotRoutingModule
  ],
  declarations: [BallotListComponent, BallotItemComponent, BallotHomeComponent, QuestionComponent, QuestionsComponent, CandidatesComponent, CandidateComponent, CandidateComponent, CandidatesComponent, VoterComponent, VotersComponent],
  providers: [BallotItemService]
})
export class BallotModule { }
