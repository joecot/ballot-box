import { Component, OnInit, Input } from '@angular/core';

@Component({
    selector: 'app-candidates',
    templateUrl: './candidates.component.html',
})
export class CandidatesComponent implements OnInit {
    @Input() candidates: any;
    @Input() ballotId: number;
    @Input() questionId: number;
    addCandidate:any;
    constructor() {
        this.addCandidate ={
            'membershipNumber': '',
            'application': '',
        };
    }
    
    ngOnInit() {
    }

}
