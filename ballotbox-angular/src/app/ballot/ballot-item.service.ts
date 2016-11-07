import { Inject, Injectable } from '@angular/core';
import {Subscription} from 'rxjs/Rx';
import { Observable }     from 'rxjs/Observable';
import { Router, Resolve,
         ActivatedRoute } from '@angular/router';
import { BallotService } from '../core/ballot.service';
import 'rxjs/Rx';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/catch';

@Injectable()
export class BallotItemService implements Resolve<any> {
    ballotId: number;
    subscription: Observable<any>;
    constructor(private ballotService: BallotService, private router: Router, private route: ActivatedRoute){}
    resolve(): Observable<any>|boolean {
        this.subscription = this.route.params.map(
            (params : any) =>
            {
                return params['id'];
            }
        );
        return this.subscription;
    }
}