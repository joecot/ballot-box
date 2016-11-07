import { Inject, Injectable } from '@angular/core';
import {Subscription} from 'rxjs/Rx';
import { Observable }     from 'rxjs/Observable';
import { BallotService } from '../core/ballot.service';
import 'rxjs/Rx';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/catch';

@Injectable()
export class BallotItemService {
    constructor(private ballotService: BallotService){}
}