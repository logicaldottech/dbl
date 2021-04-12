import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import InputRange from 'react-input-range';
// import DatePicker from 'react-date-picker';
import DatePicker from "react-datepicker";
import {SubFilterLi} from './../SubFilterLi';
import "react-datepicker/dist/react-datepicker.css";
import {ApplyFilter} from './../ApplyFilter';

export class FiscalYearFilter extends React.Component{


  constructor(props){
    super(props);

    this.state = {
      date: null,
      fiscalView: [],
      fiscalYear:[],
      startDate: null,
      companySdate:[],
      companySdateView:[],
    }

    // let current_date = new Date();
    this.handleChange = this.handleChange.bind(this);
    this.handleChangeStart = this.handleChangeStart.bind(this);
    this.clearAllCompanyDate = this.clearAllCompanyDate.bind(this);
    this.clearAll = this.clearAll.bind(this)

  }

  clearAll(){
    this.setState({fiscalView:[],fiscalYear:[], date:""});
  }

  clearAllCompanyDate(){
    this.setState({companySdate:[],companySdateView:[], startDate:""});
  }

  handleChange(date){

    if (date) {

      let day = date.getDate();
      let month = date.getMonth() + 1;

      month = month.toString();
      day = day < 10 ? '0' + day : day;


      let thedate = month + day;

      let fiscalView = this.state.fiscalView.concat(day+"-"+month);
      let fiscalYear = this.state.fiscalYear.concat(thedate);
      this.setState({fiscalView:fiscalView, fiscalYear:fiscalYear});
      console.log(thedate);
      console.log(this.state);

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

    let companySdate = this.state.companySdate.concat(newDate);
    let companySdateView = this.state.companySdateView.concat(newDate);
    this.setState({companySdate:companySdate, companySdateView:companySdateView});

    console.log('this.state.date',date);
    console.log('new date', newDate);
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

    <div id ="company-year" className="subFilterCompany">
    <ul>

      <SubFilterLi subfilter="Company Start Date">

      <div className="clearbutton"><span onClick={this.clearAllCompanyDate} >Clear All</span></div>

      <div className="clickedinclude">
          {
            this.state.companySdateView.map((v,index) =>
              <span key={index}>{v}</span>
          )
          }
      </div>

      <div className="company-date">
        <p>Select Company Start Date</p>
        <div className="date-range">
          <DatePicker
          selected={this.state.startDate}
          onChange={this.handleChangeStart}
          isClearable
          dateFormat="yyyy-MM-dd"
          placeholderText="Select Business Start Date"
          />
        </div>
      </div>

      </SubFilterLi>

      </ul>

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
