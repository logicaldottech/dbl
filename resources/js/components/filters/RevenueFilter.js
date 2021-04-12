import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import {SubFilterLi} from './SubFilterLi';
import {CodesFilter} from './CodesFilter';
import InputRange from 'react-input-range';
import Numeral from "numeral";
import {ApplyFilter} from './ApplyFilter';

Numeral.register('locale', 'en-custom', {
    delimiters: {
        thousands: ' ',
        decimal: ','
    },
    abbreviations: {
        thousand: 'Thousand',
        million: 'Million',
        billion: 'Billion',
        trillion: 'Trillion'
    },
    ordinal : function (number) {
        return number === 1 ? 'er' : 'ème';
    },
    currency: {
        symbol: '€'
    }
});

Numeral.locale('en-custom');


export class RevenueFilter extends React.Component{

 constructor(props){
   super(props);
   console.log(Numeral);
   this.state = {
     value: { min: 500000, max: 10000000000 },
   };
 }

formatLabel(){
  return false;
}

revenueAssertion(){

  let min = this.state.value.min;
  let max = this.state.value.max;

  if ( min === 500000 && max !== 10000000000 ){
    return "Under " + Numeral(this.state.value.max).format('0 a');
  } else if( min === 500000 && max === 10000000000 ){
    return "Less than $" + Numeral(this.state.value.min).format('0 a') +" to over $" + Numeral(this.state.value.max).format('0 a');
  } else{

    return "$" + Numeral(this.state.value.min).format('0 a') +" to $" + Numeral(this.state.value.max).format('0 a');

  }

}
  render() {
    return (
<div>
        <ul>
        <li>
        <div className="subFilterdiv">
        <label htmlFor="revenuerange">Revenue - {this.revenueAssertion()}</label>
        <InputRange
            maxValue={10000000000}
            minValue={500000}
            value={this.state.value}
            step={10000}
            formatLabel={this.formatLabel}
            onChange={value => {
              console.log(value);
              value.min = value.min <= 0 ? 500000 : value.min;
              this.setState({ value })
              let sendValue = value.min === 500000 && value.max === 10000000000 ? { min:0,max:10000000000} : value ;
              this.props.handleRevenue(sendValue);
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
