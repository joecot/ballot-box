import { Component, OnInit } from '@angular/core';
import { BallotService } from '../core/ballot.service';

@Component({
  selector: 'app-ballot',
  templateUrl: './ballot-list.component.html',
  styleUrls: ['./ballot-list.component.scss']
})
export class BallotListComponent implements OnInit {

  constructor(private ballotService: BallotService) { }
  ballots:any;
  ballotsSubscription:any;
  ngOnInit() {
    this.ballotsSubscription = this.ballotService.getBallots().subscribe(response => {this.ballots = response; console.log(this.ballots);});
  }

}
