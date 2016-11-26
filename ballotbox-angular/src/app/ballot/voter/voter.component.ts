import { Component, OnInit, Input } from '@angular/core';
import {BallotItemService} from '../ballot-item.service';
import {BallotService} from '../../core/ballot.service';
@Component({
    selector: 'app-voter',
    templateUrl: './voter.component.html',
})
export class VoterComponent implements OnInit {
    @Input() ballotId: any;
    @Input() voter: any;
    constructor(private ballotService: BallotService, private ballotItemService: BallotItemService) { }

    ngOnInit() {
    }

}
