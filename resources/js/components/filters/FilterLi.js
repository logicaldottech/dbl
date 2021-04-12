import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiX } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import {SubFilterLi} from './SubFilterLi';
import {CodesFilter} from './CodesFilter';


export class FilterLi extends React.Component{

 constructor(props){
   super(props);

 }

  render() {
    return (
      <li className="search-filter-li">
      <div onClick={this.props.onClick} className="filter-title" >
      <FiCheck className="search-filter-icon-check" />
      <span>{this.props.filter}</span>
      </div>{/*--.filter-title--*/}
      <div className={ this.props.active === true ? 'filter-content': 'filter-content hide'} aria-labelledby="dropdownMenuButton">
      <div className="heading">
      <p>{this.props.filter}</p>
      <FiX onClick={this.props.close} className="closeIcon"/>
      </div>

        {this.props.children}

      </div>{/*--.filter-content--*/}

      </li>
    );
  }


}
