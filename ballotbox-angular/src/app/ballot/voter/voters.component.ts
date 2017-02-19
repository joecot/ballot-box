import { Component, OnInit, Input } from '@angular/core';
import {Subscription} from 'rxjs/Rx';
import {BallotItemService} from '../ballot-item.service';
import {BallotService} from '../../core/ballot.service';

@Component({
    selector: 'app-voters',
    templateUrl: './voters.component.html',
})
export class VotersComponent implements OnInit {
    @Input() ballotId: number;
    voterSubscription:Subscription;
    voters:any;
    affiliates:any;
    addVoter:any;
    constructor(private ballotService: BallotService, private ballotItemService: BallotItemService) {
        this.addVoter ={
            'ballotId' : this.ballotId,
            'affiliateId': 0,
            'membershipNumber': '',
            'edit':false
        };
        
    }

    ngOnInit() {
        console.log('voters component init');
        this.voterSubscription = this.ballotItemService.getVoters(this.ballotId).subscribe(
            (voters) =>{
                this.voters = voters;
                console.log(this.voters);
            }
        );
    }
    
    add(){
        if(!this.affiliates){
            this.ballotService.getAffiliates().subscribe(
                (affiliates) => {
                    this.affiliates = affiliates;
                }
            )
        }
        this.addVoter.edit=true;
    }
    
    save(){
        console.log(this.addVoter);
        this.ballotService.addVoter(this.addVoter).subscribe(
            result => {
                this.addVoter = {
                    'ballotId' : this.ballotId,
                    'affiliateId': 0,
                    'membershipNumber': '',
                    'edit':false
                };
                this.ballotItemService.setBallotId(this.ballotId);
            },
            error => {this.addVoter.error = error}
        )
    }

}
