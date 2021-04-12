import React from 'react';
import ReactDOM from 'react-dom';
import {SidebarButtons} from '../components/filters/SidebarButtons';
import FilterUl from '../components/filters/FilterUl';
import {toggleSearchBy,selectCheck,getLeads,multiRemoveSearch,multiAddSearch,multiEditSearch}  from '../actions';
import { connect } from 'react-redux';
import {appliedFiltershow} from '../modules/appglobal';
class AppSidebar extends React.Component{
 constructor(props){
   super(props);

   this.testMappedProps = this.testMappedProps.bind(this);
 }

 testMappedProps(){
  console.log(this.props.search);
 }
  render() {

    const applied = {

      naics:[1234,12321]
    };
    return (

      <div className="search-sidebar">
      <div onClick={this.testMappedProps} className="search-sidebar-heading">
      <h5>Search Criteria</h5>
      </div>
      <div className="d-none" id="search-sidebar-buttons" >
      <SidebarButtons toggleSearchBy={this.props.toggleSearchBy} searchby={this.props.searchReducer.searchby}/>
      </div>
      <div id="search-sidebar-ul" className="search-sidebar-list">
      <FilterUl multiAddSearch={this.props.multiAddSearch}
      multiEditSearch={this.props.multiEditSearch}
      multiRemoveSearch={this.props.multiRemoveSearch}
      />
      </div>
      <div id="appliedfiltersdiv">
      <p>Applied Filters</p>
      {
        applied.naics.length !== 0 &&
        <p>NAICS : {applied.naics.map((v,i) =>
          <span>{v},</span>
        )}
        </p>
      }
      </div>


      </div>
    );
  }


}



const mapStateToProps = state => {
  return {
    leads: state.leadsReducer.leads,
    searchReducer: state.searchReducer,

  }
}

const mapDispactchToProps = (dispatch, ownProps ) => {
  return {
    getLeads: (leads) =>  dispatch(getLeads(leads)),
    selectAll: (lead_ids) => dispatch(selectAllLeads(lead_ids)),
    multiAddSearch: ( key,value ) => dispatch(multiAddSearch(key,value)),
    multiEditSearch: ( key,value,index ) => dispatch(multiEditSearch(key,value,index)),
    multiRemoveSearch: ( key,value,index ) => dispatch(multiRemoveSearch(key,value,index)),
    toggleSearchBy: (value) =>  dispatch(toggleSearchBy(value)),

    }
  }


export default connect( mapStateToProps, mapDispactchToProps )(AppSidebar);
