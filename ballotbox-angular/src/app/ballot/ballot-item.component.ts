import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {Subscription} from 'rxjs/Rx';
import * as moment from 'moment-timezone';
import {BallotItemService} from './ballot-item.service';
import {BallotService} from '../core/ballot.service';
@Component({
    selector: 'app-ballot-item',
    templateUrl: './ballot-item.component.html',
})
export class BallotItemComponent implements OnInit {
    private timezones:any = [{value: 1, name: 'Eastern'},{value: 2, name:'Central'},{value: 3, name:'Mountain'},{value: 4, name:'West'},{value:5, name:'Alaska'},{value:6, name:'Hawaii'}];
    private timezonesMoment:any = {1: 'America/New_York', 2: 'America/Chicago', 3: 'America/Denver', 4: 'America/Los_Angeles', 5: 'America/Anchorage', 6: 'Pacific/Honolulu'};
    private ballotSubscription: Subscription;
    private ballotIdSubscription: Subscription;
    private ballot: any;
    private ballotChanges: any;
    private ballotEdit:boolean = false;
    constructor(private route: ActivatedRoute, private ballotService: BallotService, private ballotItemService: BallotItemService) { }

    ngOnInit() {
        this.ballotSubscription = this.ballotItemService.getCurrentBallot().subscribe(
            (ballot:any) => {
                console.log('new ballot');
                console.log(ballot);
                this.ballot = ballot;
                this.ballot.edit = false;
                this.ballot.startMoment = this.localTimeMoment(this.ballot.start);
                this.ballot.startFormatted = this.ballot.startMoment.format('MMMM Do YYYY, h:mm:ss a');
                this.ballot.endMoment = this.localTimeMoment(this.ballot.end);
                this.ballot.endFormatted = this.ballot.endMoment.format('MMMM Do YYYY, h:mm:ss a');
                console.log(this.ballot);
            }
        );
        this.ballotIdSubscription = this.route.params.subscribe(params => {this.ballot = false; this.ballotItemService.setBallotId(params['id']);});
    }
    localTimeMoment(time:any){
        //I hate timezones
        //Since datetime object can't support other timezones, convert time
        //into local time
        return moment(
            moment( //parse time from unix time
                time,
                'X'
            ).tz(
                this.timezonesMoment[this.ballot.timezone] //convert to the ballot time
            ).format('MMMM Do YYYY, HH:mm:ss'), //format time without timezone
            'MMMM Do YYYY, HH:mm:ss' //parse time to local
        );
    }
    convertTimeMoment(timeMoment,timezone){
        //I hate timezones
        //Convert local time into actual timezone
        console.log(timeMoment.format('MMMM Do YYYY, HH:mm:ss'));
        return moment.tz(
            timeMoment.format('MMMM Do YYYY, HH:mm:ss'), //format time without timezone
            'MMMM Do YYYY, HH:mm:ss', //parse time to actual timezone
            this.timezonesMoment[timezone]
        );
    }
    startEdit(){
        this.ballotChanges = {
            'id': this.ballot.id,
            'name': this.ballot.name,
            'startMoment': this.ballot.startMoment.clone(),
            'endMoment': this.ballot.endMoment.clone(),
            'timezone':this.ballot.timezone
        };
        this.ballotChanges.startDate = this.ballotChanges.startMoment.toDate();
        this.ballotChanges.endDate = this.ballotChanges.endMoment.toDate();

        this.ballot.edit = true;
    }
    changeEndDate(){
        this.ballotChanges.endMoment = moment(this.ballotChanges.endDate).hour(23).minute(59).second(59);
        this.ballotChanges.endDate = this.ballotChanges.endMoment.toDate();
    }
    save(){
        this.ballotChanges.startMoment = moment(this.ballotChanges.startDate);
        this.ballotChanges.endMoment = moment(this.ballotChanges.endDate);
        this.ballotChanges.start = this.convertTimeMoment(this.ballotChanges.startMoment,this.ballotChanges.timezone).format('X');
        this.ballotChanges.end = this.convertTimeMoment(this.ballotChanges.endMoment,this.ballotChanges.timezone).format('X');
        console.log(this.ballotChanges);
        this.ballotService.saveBallot(this.ballotChanges).subscribe(
            anything => {
                this.ballotItemService.setBallotId(this.ballot.id);
                this.ballot.edit=false;
            },
            error => {this.ballotChanges.error = error}
        )
    }
}
