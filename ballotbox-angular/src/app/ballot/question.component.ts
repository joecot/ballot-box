import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-question',
  templateUrl: './question.component.html',
})
export class QuestionComponent implements OnInit {
  @Input('question') Question: any;
  constructor() { }

  ngOnInit() {
  }

}
