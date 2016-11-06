import { Component, OnInit } from '@angular/core';
import { BallotService } from '../core/ballot.service';

@Component({
  selector: 'app-ballot',
  templateUrl: './ballot.component.html',
  styleUrls: ['./ballot.component.scss']
})
export class BallotComponent implements OnInit {

  constructor(private ballotService: BallotService) { }
  ballots:any;
  ballotsSubscription:any;
  ngOnInit() {
    this.ballotsSubscription = this.ballotService.getBallots().subscribe(response => {this.ballots = response; console.log(this.ballots);});
  }

}
