import { Component } from '@angular/core';
import { UserService } from './core/user.service';
import { User } from './core/user.model';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app works!';
  userSubscription: any;
  user : User;
  constructor(private userService: UserService){
    
  }
  ngOnInit(){
    this.userSubscription = this.userService.getCurrentUser().subscribe(response => { this.user = response; console.log(response);});
  }
}
