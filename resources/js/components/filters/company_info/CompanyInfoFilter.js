import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import InputRange from 'react-input-range';
import {ApplyFilter} from './../ApplyFilter';

import { FaWindowClose } from "react-icons/fa";

export class CompanyInfoFilter extends React.Component{

  constructor(props){
     super(props);

     this.state = { legal:"", dba:"",legalvalue:'',dbavalue:''};

     this.handleChangeLegal = this.handleChangeLegal.bind(this);
     this.handleChangeDba = this.handleChangeDba.bind(this);
     this.clearInputValueLegal = this.clearInputValueLegal.bind(this);
     this.clearInputValueDba = this.clearInputValueDba.bind(this);
   }

   handleChangeLegal(e){
    e.preventDefault();

    let value = e.target.value;
    let splitValue = value.split('\n')
    let catchedValue  = splitValue.filter( function(el){
      return el !== '';
    });
    //let valid = this.state.url.every(this.testUrl);
    this.setState({legal:catchedValue,legalvalue:value});
    this.props.handleValue('business_name',catchedValue);
    console.log(this.state)
   }

   handleChangeDba(e){
    e.preventDefault();

    let value = e.target.value;
    let splitValue = value.split('\n')
    let catchedValue  = splitValue.filter( function(el){
      return el !== '';
    });
    //let valid = this.state.url.every(this.testUrl);
    this.setState({dba:catchedValue,dbavalue:value});
    this.props.handleValue('dba_name',catchedValue);
    console.log(this.state)

   }

    clearInputValueLegal(e){
    e.preventDefault();

    this.setState({ legal: [],legalvalue:'' });
		this.props.handleValue('business_name',[]);

    }

  clearInputValueDba(e){
    e.preventDefault();
    this.setState({ dba: [],dbavalue:'' });
    this.props.handleValue('dba_name',[]);


  }

   render() {
    return (
    <div className="subFilterCompanyInfo">
      <div className="companyInfo-heading">
        You can search Leads by Legal Business Name and DBA name.
        </div>
      <div className="legal-name">
        <label htmlFor="legalName">By Legal Business Name <span onClick = {this.clearInputValueLegal} className="clearUrl"> clear all <FaWindowClose/> </span></label>
      <textarea  value={this.state.legalvalue} onChange = {(e) => this.handleChangeLegal(e)} className="companyUrl" rows="2" cols="23" />
      </div>
      <div className="dba-name">
      <label htmlFor="dbaName">By DBA Name <span onClick = {this.clearInputValueDba} className="clearUrl"> clear all <FaWindowClose/> </span></label>
      <textarea value={this.state.dbavalue} onChange = {(e) => this.handleChangeDba(e)} className="companyUrl" rows="2" cols="23" />
      </div>

      <ApplyFilter
				search={this.props.search}
				getLeads={this.props.getLeads}
				setLoader={this.props.setLoader}
			 />
    </div>

    );
  }
}
