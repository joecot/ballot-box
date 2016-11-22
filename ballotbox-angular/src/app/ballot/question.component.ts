import { Component, OnInit, Input } from '@angular/core';

@Component({
    selector: 'app-question',
    templateUrl: './question.component.html',
})
export class QuestionComponent implements OnInit {
    @Input() question: any;
    @Input() ballotId: number;
    private questionChanges: any;
    private questionEdit:boolean = false;
    constructor() { }
    
    ngOnInit() {
        this.question.edit = false;
    }
  
    startEdit(){
        this.questionChanges = {
            'name': this.question.name,
            'type': this.question.type,
            'count': this.question.count,
            'description': this.question.description,
            'readmore': this.question.readmore,
            'discussion': this.question.discussion
        };
        if(this.question.id) this.questionChanges.id = this.question.id;
        if(!this.question.isNew) this.question.isNew = false;
        else this.question.isNew = true;
        this.question.edit = true;
    }

}
