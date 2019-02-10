import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class App extends Component {
	constructor(props) {
		super(props);

		this.state = {
			longurl: '',
			submiturl: '',
			shorturl: '',
			display: 'none'
		}
		this.updatelongurl = this.updatelongurl.bind(this);
		this.submiturl = this.submiturl.bind(this);
		this.errorMsg = React.createRef();
	}
	updatelongurl(e) {
		this.setState({longurl: e.target.value});
	}
	componentDidMount(){
	}
	submiturl() {
		var self = this;
		fetch('ls/getlink', {
	       method:'post',
	       headers: {
	         'Accept': 'application/json',
	         'Content-Type': 'application/json',
	         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	       },
	       body: JSON.stringify(this.state.longurl)
	   })
	   .then(function(response) {
	       return response.json();
	   })
	   .then(function(result){
	   		console.log(result);
	   		if(result) {
	   			self.setState({shorturl: result});
	   			setTimeout(
				    function() {
				        self.setState({display: 'none'});
				    }
				    .bind(self),
				    300
				);
	   		} else {
	   			self.setState({display: 'block', shorturl: ''});
	   			setTimeout(
				    function() {
				        self.setState({display: 'none'});
				    }
				    .bind(self),
				    10000
				);
	   		}
	   });
	}
  	render () {
	    return (
	      <div className="ls_app">
	      	<div className="error" style={{display: this.state.display}}>
	      		Hi there, to get a shortened link, you need to enter a valid url, one that starts with either an 'http' or 'https', and ends with a valid extension. Okay? thanks!
	      	</div>
	        <div className="longurl-input">
	          <input type="text" name="longurl" value={this.state.longurl} className="longurl" onChange={this.updatelongurl} /> <i className="fas fa-chevron-circle-right longurl_submit" onClick={this.submiturl}></i>
	        </div>
	        <div className="shortenedurl-container">
	        	{this.state.shorturl}
	        </div>
	      </div>
	    )
	  }
}


ReactDOM.render(<App />, document.getElementById('main'))