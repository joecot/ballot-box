import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-voting',
  templateUrl: './voting.component.html',
  styleUrls: ['./voting.component.scss']
})
export class VotingComponent implements OnInit {

  constructor() {
    console.log('voting component constructor called');
  }

  ngOnInit() {
    console.log('voting component oninit called');
  }

}
