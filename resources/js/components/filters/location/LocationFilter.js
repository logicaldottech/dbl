import React, {Component, Fragment} from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import {SubFilterLi} from '../SubFilterLi';
import {CountryName} from './CountryName';

import ToggleSwitch from '../switch/ToggleSwitch';


export class LocationFilter extends React.Component{

 constructor(props){
   super(props);

   this.search = this.search.bind(this);


 }

 search(){
   console.log(this.props.search);
//   this.props.setLoader(true);

   let query = this.props.search;
   this.props.setLoader(true);

   axios({
     method:'post',
     url:APP_URL + '/api/search',
     data:query
   }).then( res =>{
       console.log(res.data);
       this.props.getLeads(res.data.leads,res.data.paginate);

       this.props.setLoader(false);

     })
     .catch( error => {
       console.log(error);
      // this.setState({ isLoading:true });

     });

 }
  render() {
    return (
      <>
      <div className="location-lable">
      <ToggleSwitch id="location" name="location" />
        <p className="location-filter-lable">
          You are curuntly filter by physical location, To filter By mailing location please toggle right
        </p>

        <ul>

        <SubFilterLi subfilter="Country">
        <CountryName
          multiAddSearch={this.props.multiAddSearch}
          search={this.props.search}
          leads={this.props.leads}
          getLeads={this.props.getLeads}
          clearAll={this.props.clearFilterArray}
          setLoader={this.props.setLoader}
          countries={this.props.countries}
        />
        </SubFilterLi>

        </ul>
        <div onClick={this.search} className="done-filter">
        <FiCheck className="" />
        <span>Apply Filter</span>
        </div>
        </div>
        </>
    );
  }


}
