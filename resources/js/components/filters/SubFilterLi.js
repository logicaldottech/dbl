import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import { FiChevronUp } from "react-icons/fi";


export class SubFilterLi extends React.Component{
 constructor(props){

   super(props);
   this.state = { Dropdown: false };
   this.toggleDropdown = this.toggleDropdown.bind(this);
 }



 toggleDropdown(e){
   e.stopPropagation();
   console.log(e);
   this.setState({ Dropdown: !this.state.Dropdown });
 }

  render() {
    return (
      <li>

      <div onClick={(e) => this.toggleDropdown(e)}  className={this.state.Dropdown ? "subfilter-title-div active": "subfilter-title-div" }>
      <span>{this.props.subfilter}</span>

      {this.state.Dropdown ? <FiChevronUp /> : <FiChevronDown /> }
      </div>
      <div className={this.state.Dropdown ? 'subfilter-dropdown' : 'd-none' }>
        {this.props.children}
      </div>
      </li>
    );
  }


}
