import { Inject, Injectable } from '@angular/core';
import {Subscription} from 'rxjs/Rx';
import { Observable }     from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';
import { BallotService } from '../core/ballot.service';
import 'rxjs/Rx';
import 'rxjs/add/operator/map';

@Injectable()
export class BallotItemService {
    ballot: Observable<any>;
    ballotId: Subject<any> = new Subject();
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
}