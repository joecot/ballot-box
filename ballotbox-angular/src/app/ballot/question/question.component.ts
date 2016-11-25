import { Component, OnInit, Input } from '@angular/core';
import {BallotItemService} from '../ballot-item.service';
import {BallotService} from '../../core/ballot.service';

@Component({
    selector: 'app-question',
    templateUrl: './question.component.html',
})
export class QuestionComponent implements OnInit {
    @Input() question: any;
    @Input() ballotId: number;
    private questionChanges: any;
    private countOptions:number[] = [1,2,3,4,5,6,7,8,9];
    constructor(private ballotService: BallotService, private ballotItemService: BallotItemService) { }
    
    ngOnInit() {
        this.question.edit = false;
    }
  
    startEdit(){
        this.questionChanges = {
            'ballotId' : this.ballotId,
            'name': this.question.name,
            'type': this.question.type,
            'count': this.question.count,
            'description': this.question.description,
            'readmore': this.question.readmore,
            'discussion': this.question.discussion
        };
        if(this.question.id) this.questionChanges.id = this.question.id;
 
        this.question.edit = true;
    }
    save(){
        console.log(this.questionChanges);
        this.ballotService.saveQuestion(this.questionChanges).subscribe(
            question => {
                this.ballotItemService.setBallotId(this.ballotId);
                this.question.edit=false;
            },
            error => {this.questionChanges.error = error}
        )
    }

}
