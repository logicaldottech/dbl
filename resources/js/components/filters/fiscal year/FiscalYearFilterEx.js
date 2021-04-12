import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import InputRange from 'react-input-range';
// import DatePicker from 'react-date-picker';
import DatePicker from "react-datepicker";

import "react-datepicker/dist/react-datepicker.css";
import {ApplyFilter} from './../ApplyFilter';

export class FiscalYearFilter extends React.Component{


  constructor(props){
    super(props);

    this.state = {
      date: null,
      startDate: null,
      endDate: null
    }

    // let current_date = new Date();
    this.handleChange = this.handleChange.bind(this);
    this.handleChangeStart = this.handleChangeStart.bind(this);
    this.handleChangeEnd = this.handleChangeEnd.bind(this);
  }

  handleChange(date){

    if (date) {

      let day = date.getDate();
      let month = date.getMonth() + 1;

      month = month.toString();
      day = day < 10 ? '0' + day : day;


      let thedate = month + day;

      console.log(thedate);
      console.log('month',month);
      console.log('day',day);

    }

    this.setState({date: date});
  }

  handleChangeStart(date){

    let year = date.getFullYear();
    let day = date.getDate();
    let month = date.getMonth() + 1;

    day = day < 10 ? '0' + day : day;

    month = month < 10 ? '0' + month : month;

    let newDate = year + "-" + month + "-" + day;

    console.log('this.state.date',date);
    console.log('new date', newDate);
    this.setState({startDate: newDate});
  }

  handleChangeEnd(date){

    console.log('this.state.date',date);
    this.setState({endDate: date});
  }

  render() {
    const startDate = new Date();
    startDate.setYear(startDate.getFullYear());
    startDate.setMonth("00");
    startDate.setDate("01");

    const endDate = new Date();
    endDate.setYear(endDate.getFullYear());
    endDate.setMonth("11");
    endDate.setDate("31");

    return (

    <div id ="fiscal-year" className="subFilterCompany">
      <div className="company-heading">
        Select Company date range from start to end date and add Fiscal Year End close date to search leads
      </div>

      <div className="fiscal-close">
        <p className="endCloseFiscal">Fiscal End Close Date</p>
        <DatePicker
          selected={this.state.date}
          minDate={startDate}
          maxDate={endDate }
          dateFormat="MM-dd"
          onChange={this.handleChange}
          isClearable
          placeholderText="Select Fiscal Year Date"
        />
      </div>

      <div className="fiscal-start">
        <p className="endCloseFiscal">Company Start Date Range</p>
        <div className="date-range">
          <label htmlFor="fstartdate" className="fdate-start"> From </label>
          <DatePicker
          selected={this.state.startDate}
          onChange={this.handleChangeStart}
          isClearable
          dateFormat="yyyy-MM-dd"
          placeholderText="Select Business Start Date"
          />
          <label htmlFor="fenddate" className="fdate-end"> To </label>
          <DatePicker
            selected={this.state.endDate}
            dateFormat="yyyy-MM-dd"
            onChange={this.handleChangeEnd}
            isClearable
            placeholderText="Select Business End Date"
          />
        </div>
      </div>

      <ApplyFilter
        search={this.props.search}
        leads={this.props.leads}
        getLeads={this.props.getLeads}
        setLoader={this.props.setLoader}
        valid={this.state.valid}
        error='You have entered the wrong url format'
       />
    </div>

    );
  }


}
