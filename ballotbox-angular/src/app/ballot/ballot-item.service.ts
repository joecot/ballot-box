import { Inject, Injectable } from '@angular/core';
import {Subscription} from 'rxjs/Rx';
import { Observable }     from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';
import { BehaviorSubject } from 'rxjs/Rx';
import { BallotService } from '../core/ballot.service';
import 'rxjs/Rx';
import 'rxjs/add/operator/map';

@Injectable()
export class BallotItemService {
    ballot: Observable<any>;
    ballotId: Subject<any> = new Subject();
    voterBallotId: BehaviorSubject<number>;
    voters: Observable<any>;
    constructor(private ballotService: BallotService){
        console.log('ballot item service constructed');
        this.ballot = this.ballotId.asObservable().switchMap(
            (ballotId: any)=>
            {
                console.log('switchmap called '+ballotId);
                return this.ballotService.getBallot(ballotId);
            }
        )
    }
    setBallotId(ballotId:number){
        this.ballotId.next(ballotId);
    }
    getCurrentBallot():Observable<any>{
        return this.ballot;
    }
    getVoters(ballotId:number){
        if(!this.voterBallotId) this.startVoterSubject(ballotId);
        if(ballotId != this.voterBallotId.getValue()) this.voterBallotId.next(ballotId);
        return this.voters;
    }
    
    refreshVoters(){
        this.voterBallotId.next(this.voterBallotId.getValue());
    }
    
    startVoterSubject(ballotId:number){
        this.voterBallotId = new BehaviorSubject(ballotId);
        this.voters = this.voterBallotId.asObservable().switchMap(
            (ballotId: any)=>
            {
                console.log('switchmap called '+ballotId);
				return this.ballotService.getVoters(ballotId);
            }
        );
    }
}