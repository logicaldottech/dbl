import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import {SubFilterLi} from './SubFilterLi';
import {CodesFilter} from './CodesFilter';
import InputRange from 'react-input-range';
import {ApplyFilter} from './ApplyFilter';


export class EmployeeFilter extends React.Component{

 constructor(props){
   super(props);
   this.state = {
     value: { min: 5, max: 10000 },
   };
 }

formatLabel(){
  return false;
}

revenueAssertion(){

  let min = this.state.value.min;
  let max = this.state.value.max;

  if ( min === 5 && max !== 10000 ){
    return "Under " + this.state.value.max;
  } else if( min === 5 && max === 10000 ){
    return "Less than " + this.state.value.min +" to over " + this.state.value.max;
  } else{

    return this.state.value.min +" to " + this.state.value.max;

  }

}
  render() {
    return (
<div>
        <ul>
        <li>
        <div className="subFilterdiv">
        <label htmlFor="revenuerange">{this.revenueAssertion()}</label>
        <InputRange
            maxValue={10000}
            minValue={5}
            value={this.state.value}
            step={50}
            formatLabel={this.formatLabel}
            onChange={value => {
              console.log(value);
              value.min = value.min <= 0 ? 5 : value.min;
              this.setState({ value })
              this.props.handleEmployee(value);

            }
          }
            />
        </div>
        </li>
        </ul>
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
