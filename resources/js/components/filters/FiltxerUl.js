import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import {FilterLi} from './FilterLi';
import {IndustryFilter} from './IndustryFilter';


export class FilterUl extends React.Component{

 constructor(props){
   super(props);

   const filters = [
     {
       name:"Industry",
       children:<IndustryFilter/>
     },
     {
       name:"Location",
       children:<IndustryFilter/>
     },
     {
       name:"Revenue",
       children:<IndustryFilter/>
     },
     {
       name:"Company Information",
       children:<IndustryFilter/>
     },
     {
       name:"Employees",
       children:<IndustryFilter/>
     },
   ]

   this.state = { filters: filters, activeItem: false };
   this.openSubfilters = this.openSubfilters.bind(this);


 }

  openSubfilters(e ){
    //e.stopPropagation();
    this.setState(
      {  activeItem: activeItem });

      console.log( this.setState.activeItem  );
      if ( this.state.showSub ){
        document.getElementById('app-main-table').style.opacity = '1';
      } else {
        document.getElementById('app-main-table').style.opacity = '.5';
      }
  }


  render() {
    return (
      <ul>
        { this.state.filters.map( (filter, index ) => <FilterLi key={index} onClick={(e ) => this.openSubfilters(e) } active={ this.state.activeItem === index ? true : false } filter={filter.name}>{filter.children}</FilterLi>)
       }

      </ul>

    );
  }


}
