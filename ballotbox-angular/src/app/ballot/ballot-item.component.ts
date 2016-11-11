import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {Subscription} from 'rxjs/Rx';
import {BallotItemService} from './ballot-item.service';
@Component({
    selector: 'app-ballot-item',
    templateUrl: './ballot-item.component.html',
})
export class BallotItemComponent implements OnInit {
    private timezones:any = [{value: 1, name: 'Eastern'},{value: 2, name:'Central'},{value: 3, name:'Mountain'},{value: 4, name:'West'},{value:5, name:'Alaska'},{value:6, name:'Hawaii'}];
    private ballotSubscription: Subscription;
    private ballotIdSubscription: Subscription;
    private ballot: any;
    private ballotEdit:boolean = false;
    constructor(private route: ActivatedRoute, private ballotItemService: BallotItemService) { }

    ngOnInit() {
        this.ballotSubscription = this.ballotItemService.getCurrentBallot().subscribe(
            (ballot:any) => {
                this.ballot = ballot;
            }
        );
        this.ballotIdSubscription = this.route.params.subscribe(params => {this.ballot = false; this.ballotItemService.setBallotId(params['id']);});
    }

}
