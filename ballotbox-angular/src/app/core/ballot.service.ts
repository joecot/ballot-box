import { Inject, Injectable } from '@angular/core';
import {Http, Headers, URLSearchParams, RequestOptions, Response} from '@angular/http';
import {Subscription} from 'rxjs/Rx';
import { BehaviorSubject } from 'rxjs/Rx';
import { Observable }     from 'rxjs/Observable';
import 'rxjs/Rx';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/catch';

@Injectable()
export class BallotService {
	apiUrl: string;
	currentUser: Observable<any>;
	ballots: Observable<any>;
	ballotsRefresh: BehaviorSubject<boolean> = new BehaviorSubject(false);
	//private headers = new Headers();
	constructor(private http: Http){
		this.apiUrl = 'app.php/API/';
		//this.headers.append('x-CSRFToken', this.apiToken);
		this.ballots = this.ballotsRefresh.asObservable().switchMap(
            ()=>
            {
                console.log('ballots switchmap called');
                return this.http.get(this.apiUrl+'ballots').map(response => response.json()).first().catch(this.handleError);
            }
        )
	}
	
	getBallots(){
	    return this.ballots;
	}
	
	refreshBallots(){
		this.ballotsRefresh.next(false);
	}
	
	getBallot(id:number){
	    return this.http.get(this.apiUrl+'ballots/'+id).map(response => response.json()).first().catch(this.handleError);
	}
	
	saveBallot(ballot:any){
		let headers = new Headers({ 'Content-Type': 'application/json' });
	    let options = new RequestOptions({ headers: headers });
	    let ballotPost = {'id':0,'name':ballot.name,'start':ballot.start,'end':ballot.end, 'timezone': ballot.timezone};
	    var url = '';
	    if(ballot.id){ ballotPost.id = ballot.id; url = 'ballots/'+ballot.id}
	    else{ url = 'ballots';}
	    return this.http.post(this.apiUrl+url, ballotPost, options)
	    	.map(response => response.json())
	    	.first()
			.catch(this.handleError);
		//return this.http.post(this.apiUrl+'ballots/'+ballot.id,)
	}
	
	private handleError (error: Response | any) {
		// In a real world app, we might use a remote logging infrastructure
		let errMsg: string;
		if (error instanceof Response) {
			if(error.status == 401){
				window.location.href = '/app.php/login?jspath=/';
			}
			const body = error.json() || '';
			const err = body.error || JSON.stringify(body);
			errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
		} else {
			errMsg = error.message ? error.message : error.toString();
		}
		console.error(errMsg);
		return Observable.throw(errMsg);
	}
	
	get(pathUrl: string): Observable<any>{
		return this.http.get(this.apiUrl+pathUrl, {
			//headers: this.headers
		});
	}
	
	patch(pathUrl:string, body:string): Observable<any>{
		return this.http.patch(this.apiUrl+pathUrl, body, {});
	}
	
	
}