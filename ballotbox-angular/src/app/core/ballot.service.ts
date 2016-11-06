import { Inject, Injectable } from '@angular/core';
import {Http, Headers, URLSearchParams, Response} from '@angular/http';
import {Subscription} from 'rxjs/Rx';
import { Observable }     from 'rxjs/Observable';
import 'rxjs/Rx';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/catch';

@Injectable()
export class BallotService {
	apiUrl: string;
	currentUser: Observable<any>;
	//private headers = new Headers();
	constructor(private http: Http){
		this.apiUrl = 'app.php/API/';
		//this.headers.append('x-CSRFToken', this.apiToken);
	}
	
	getBallots(){
	    return this.http.get(this.apiUrl+'ballots').map(response => response.json()).first().catch(this.handleError);
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