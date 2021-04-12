import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import InputRange from 'react-input-range';
import {ApplyFilter} from './../ApplyFilter';

import { FaWindowClose } from "react-icons/fa";

export class CompanyUrlFilter extends React.Component{

	constructor(props){
	   super(props);

	   this.state = { value:"",url:['']};

	   this.handleChange = this.handleChange.bind(this);
	   this.clearInputValue = this.clearInputValue.bind(this);
	 }

	 testUrl(value){
		 let urlPattern = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
		 return urlPattern.test(value);
	 }

	 handleChange(e){
	 	e.preventDefault();

		let value = e.target.value;
		let splitValue = value.split('\n')
		let catchedValue  = splitValue.filter( function(el){
			return el !== '';
		});
		//let valid = this.state.url.every(this.testUrl);
		this.setState({url: catchedValue,value:value});
		this.props.handleValue('url',catchedValue);
		console.log(this.state)
	 }

	clearInputValue(e){
		e.preventDefault();
		this.setState({ value: '' });
		this.props.handleValue('url',[]);

	}

	 render() {
    return (
    <div className="subFilterCompany">
    	<div className="company-heading">
    		To target by specific companies, please enter or upload al list of domain names only i.e. amazon.com
    	</div>
    	<div className="company-inputs">
	    <label htmlFor="companyurl">By Company URL <span onClick = {this.clearInputValue} id="clearUrl"> clear all <FaWindowClose/> </span></label>
	    <textarea value ={this.state.value} onChange = {(e) => this.handleChange(e)} className="companyUrl" rows="2" cols="23" />
	    </div>
	    <div className="d-none upload-btn">
	    	<button id="company-upload-btn" className="company-btn">Upload A List</button>
	    	<button id="company-list-btn" className="company-btn">Select From My List</button>
	    </div>
			<ApplyFilter
				search={this.props.search}
				leads={this.props.leads}
				getLeads={this.props.getLeads}
				setLoader={this.props.setLoader}
			 />
    </div>

    );
  }
}
