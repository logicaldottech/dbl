import React, {Component, Fragment} from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import InputRange from 'react-input-range';
import DatePicker from 'react-date-picker';
import {SubFilterLi} from '../SubFilterLi';
import ToggleSwitch from '../switch/ToggleSwitch';

export class BusinessStartDateFilter extends React.Component{


  constructor(props){
    super(props);

    this.state = {
      date: "",
      startDate: new Date(),
      endDate: new Date()
    }

    this.handleChange = this.handleChange.bind(this);
    this.handleChangeStart = this.handleChangeStart.bind(this);
    this.handleChangeEnd = this.handleChangeEnd.bind(this);
  }

  handleChange(date){

    console.log('this.state.date',date);
    this.setState({date: date});
  }

  handleChangeStart(date){

    console.log('this.state.date',date);
    this.setState({startDate: date});
  }

  handleChangeEnd(date){

    console.log('this.state.date',date);
    this.setState({endDate: date});
  }

  render() {
    return (
    <>
    <div id ="business-start-date" className="subFilterCompany">
      <div className="company-heading">
        Select Company date range from start to end date to search leads
      </div>

      <ul>
        <SubFilterLi subfilter="Company Start Date Range">

        <ToggleSwitch name="businessDate" />
          <p className="location-filter-lable">
            To filter By Single Business Start Date please toggle right.
          </p>
          <div className="fiscal-start">
            <p className="endCloseFiscal">Company Start Date Range</p>
            <div className="date-range">
              <label htmlFor="fstartdate" className="fdate-start"> From </label>
              <DatePicker
              onChange={this.handleChangeStart}
              value={this.state.startDate}
              />
              <label htmlFor="fenddate" className="fdate-end"> To </label>
              <DatePicker
              onChange={this.handleChangeEnd}
              value={this.state.endDate}
              />
            </div>
          </div>

        </SubFilterLi>
      </ul>

    </div>
    <div onClick={this.search} className="done-filter">
      <FiCheck className="" />
      <span>Apply Filter</span>
    </div>
    </>
    );
  }


}
