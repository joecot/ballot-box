import { Component, OnInit, Input } from '@angular/core';

@Component({
    selector: 'app-questions',
    templateUrl: './questions.component.html',
})
export class QuestionsComponent implements OnInit {
    @Input() questions: any;
    @Input() ballotId: number;
    addQuestion:any;
    constructor() {
        this.addQuestion ={
            'name': '',
            'type': 'office',
            'count': 1,
            'description': null,
            'readmore': null,
            'discussion': null
        };
    
    }
    
    ngOnInit() {
    }
}