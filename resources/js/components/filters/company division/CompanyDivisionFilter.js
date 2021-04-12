import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { Multiselect } from 'multiselect-react-dropdown';
import { FaWindowClose } from "react-icons/fa";
import {APP_URL} from '../../../constants/site';
import axios from 'axios';

export class CompanyDivisionFilter extends React.Component{

	constructor(props){
	   super(props);

	   this.state = {

	   		dNumber:"",
	   		options: [{name: 'value 1', id: 1},{name: 'value', id: 2},{name: 'value 3', id: 3}]

	    };

	   this.handleChange = this.handleChange.bind(this);
	   this.clearInputValue = this.clearInputValue.bind(this);
	 }

	 handleChange(e){
	 	e.preventDefault();

	 	this.state.dNumber = e.target.value;

	 	this.setState({dNumber: this.state.dNumber});
	 }

	clearInputValue(e){
		e.preventDefault();

		this.setState({ dNumber: '' });
	}

	onSelect(selectedList, selectedItem) {

	}

	onRemove(selectedList, removedItem) {

	}

  componentDidMount() {

		axios.post(APP_URL + '/api/get_division')
		.then( res =>{
			console.log('api get division');
			console.log(res);

			console.log(newArr);



		})
	  .catch(function (error) {
	    console.log(error);
	  })
	  .then(function () {
	    // always executed
	  });
  }

	 render() {

    return (
    <div id ="comDivision" className="subFilterCompany">
    	<div className="company-heading">
    		Select Company division or add Division number to search leads
    	</div>

    	<div className="company-division">
    		<Multiselect
				options={this.state.options} // Options to display in the dropdown
				selectedValues={this.state.selectedValue} // Preselected value to persist in dropdown
				onSelect={this.onSelect} // Function will trigger on select event
				onRemove={this.onRemove} // Function will trigger on remove event
				displayValue="name" // Property name to display in the dropdown options
				/>
    	</div>
    	<div className="company-inputs divisionNumber">
	    	<label htmlFor="divisionnumber">By Company Division <span onClick = {this.clearInputValue} id="clearUrl"> clear all <FaWindowClose/> </span></label>
	    	<textarea value = {this.state.dNumber} onChange = {(e) => this.handleChange(e)} className="companyNumber" rows="2" cols="23" />
	    </div>

	    <div onClick={this.search} className="done-filter">
        <FiCheck className="" />
        <span>Apply Filter</span>
        </div>
    </div>

    );
  }
}
