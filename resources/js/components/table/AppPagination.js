import React from 'react';
import ReactDOM from 'react-dom';
import { FiSquare } from "react-icons/fi";

import {FiChevronsRight,FiChevronsLeft,FiDownload,FiMoreHorizontal,FiChevronLeft,FiChevronRight} from "react-icons/fi";
import ReactPaginate from 'react-paginate';
import Pagination from "react-js-pagination";


export class AppPagination extends React.Component{

  constructor(props){

    super(props);
    this.handleGoTo = this.handleGoTo.bind(this);
    this.state = { goTo:1}
    this.handlePageChange = this.handlePageChange.bind(this);
    this.handlePerPageChange = this.handlePerPageChange.bind(this);

  }

   handleGoTo( event ){
     this.setState({goTo: event.target.value});
   }

   handlePageChange(pageNumber){
     console.log(pageNumber)
     this.props.goToPage(pageNumber,this.props.perPage);
   }

   handlePerPageChange(event) {
      console.log(this.state);
      this.props.handleValue('perPage',event.target.value);
      this.props.goToPage(1,event.target.value);
    }

  render(){
    return (
      <nav className="pagination-nav">

      <Pagination
      activePage={this.props.paginate.currentPage}
      itemsCountPerPage={10}
      totalItemsCount={450}
      pageRangeDisplayed={10}
      prevPageText={<FiChevronLeft/>}
      nextPageText={<FiChevronRight/>}
      firstPageText={<FiChevronsLeft/>}
      activeClass='pageActive'
      lastPageText={<FiChevronsRight/>}
      itemClass='page-item'
      linkClass='page-link'
      linkClassNext='next-link'
      linkClassPrev='previous-link'
      linkClassFirst='next-link'
      linkClassLast='previous-link'

      onChange={this.handlePageChange}
    />


    <div className="perGo">
      <div className="perPage">
      <span>Per Page</span>
      <select onChange={this.handlePerPageChange} value={this.props.perPage} className="custom-select">
      <option value="5" >5</option>
      <option value="10" >10</option>
      <option value="25" >25</option>
      <option value="100" >100</option>
      <option value="1000" >1000</option>
      </select>
      </div>

      <div className="gotonav">
      <span>Go To Page</span>
      <input id="goToPage" min="1" onChange={this.handleGoTo} className="form-control" value={this.state.goTo} type="number"/>
      <button onClick={(pageNumber) => this.props.goToPage(this.state.goTo,this.props.perPage)} className="btn">GO</button>
      </div>
</div>

   </nav>
    );
  };

}
