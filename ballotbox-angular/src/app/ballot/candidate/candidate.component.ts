import { Component, OnInit, Input } from '@angular/core';
import {BallotItemService} from '../ballot-item.service';
import {BallotService} from '../../core/ballot.service';

@Component({
    selector: 'app-candidate',
    templateUrl: './candidate.component.html',
})
export class CandidateComponent implements OnInit {
    @Input() candidate: any;
    @Input() ballotId: number;
    @Input() questionId: number;
    private candidateChanges: any;


    constructor(private ballotService: BallotService, private ballotItemService: BallotItemService) { }

    ngOnInit() {
        this.candidate.edit = false;
    }
    
    startEdit(){
        this.candidateChanges = {
            'ballotId' : this.ballotId,
            'questionId' : this.questionId,
            'membershipNumber': this.candidate.membershipNumber,
            'application': this.candidate.application,
        };
        if(this.candidate.id) this.candidateChanges.id = this.candidate.id;
 
        this.candidate.edit = true;
    }
    
    save(){
        console.log(this.candidateChanges);
        this.ballotService.saveCandidate(this.candidateChanges).subscribe(
            candidate => {
                this.ballotItemService.setBallotId(this.ballotId);
                this.candidate.edit=false;
            },
            error => {this.candidateChanges.error = error}
        )
    }

}
