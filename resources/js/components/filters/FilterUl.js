import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import {FilterLi} from './FilterLi';
import {IndustryFilter} from './IndustryFilter';
import {RevenueFilter} from './RevenueFilter';
import {EmployeeFilter} from './EmployeeFilter';
import {CompanyUrlFilter} from './company url/CompanyUrlFilter';
import { connect } from 'react-redux';
import {handleToggleValue,handleValue,setLoader,clearFilterArray,getLeads,getIndustries,getCountries,getLoader,handleRevenue,handleEmployee,toggleIndustryCategory}  from '../../actions';
import {APP_URL} from '../../constants/site';
import {LocationFilter} from './location/LocationFilter';
import {CompanyInfoFilter} from './company_info/CompanyInfoFilter';
import {CompanyDivisionFilter} from './company division/CompanyDivisionFilter';
import {IndustryCategory} from './industry/IndustryCategory';
import {IndustryName} from './industry/IndustryName';
import {SuggestionInput} from './SuggestionInput';




 class FilterUl extends React.Component{

 constructor(props){
   super(props);

   this.state = {  activeItem: 6 };
   this.openSubfilters = this.openSubfilters.bind(this);
   this.filterLiRef = React.createRef();
   this.handleOutsideClick = this.handleOutsideClick.bind(this);

 }

    componentDidMount() {

     axios({
       method:'get',
       url:APP_URL + '/api/allindustries',
     }).then( res =>{
         console.log(res.data);
         this.props.getIndustries(res.data);
       })
       .catch( error => {
         console.log(error);
       });

       axios({
         method:'get',
         url:APP_URL + '/api/getcountries',
       }).then( res =>{
           console.log(res.data);
           this.props.getCountries(res.data);
         })
         .catch( error => {
           console.log(error);
         });

   }

  openSubfilters(e, index ){
    //console.log(e);
    console.log(this.filterLiRef);
    console.log(this.state);

    this.setState( ( state ) => (  { activeItem: state.activeItem === index ? false : index }) );
      if ( this.state.activeItem === false ){
        document.getElementById('app-main-table').style.opacity = '.5';
      } else {
        document.getElementById('app-main-table').style.opacity = '1';
      }

        document.addEventListener('mousedown', this.handleOutsideClick, false);

  }

  closeSubfilters(e){
    this.setState(
      {  activeItem: false });
      document.getElementById('app-main-table').style.opacity = '1';

    //  document.addEventListener('click', this.handleOutsideClick, false);
    document.removeEventListener('mousedown', this.handleOutsideClick, false);

  }


handleOutsideClick(e){
  // console.log(e);
  // console.log(this.filterLiRef);

  let targeted = e.target.closest('.search-filter-li');
  // console.log(targeted);
  // console.log(e.target);
  // || e.target.classList.contains('suggestionSpan') === true
  // || e.target.classList.contains('react-autosuggest__suggestion') === true
  if ( targeted !== null
 ){
    // console.log('yes')
  } else {
    // console.log('no')
    this.setState(
      {  activeItem: false });
      document.getElementById('app-main-table').style.opacity = '1';
      document.removeEventListener('mousedown', this.handleOutsideClick, false);

    // this.setState(
    //   {  activeItem: false });
  }
  // if ( this.filterLiRef.current.contains(e.target) ){
  //   console.log('yes')
  // } else {
  //   console.log('no')
  //   this.setState(
  //     {  activeItem: false });
  // }

}
  render() {

    const filters = [
      {
        name:"Industry Categories",
        children:<IndustryCategory
        multiAddSearch={this.props.multiAddSearch}
        toggleIndustryCategory={this.props.toggleIndustryCategory}
        setLoader={this.props.setLoader} search={this.props.search}
        handleValue={this.props.handleValue}

        />
      },
      {
        name:"Industry Name",
        children:<IndustryName
        multiAddSearch={this.props.multiAddSearch}
        toggleIndustryCategory={this.props.toggleIndustryCategory}
        setLoader={this.props.setLoader} search={this.props.search}
        industries={this.props.industries}
        clearAll={this.props.clearFilterArray}
        getLeads={this.props.getLeads}

        />
      },
      {
        name:"Industry Codes",
        children:<IndustryFilter
        multiEditSearch={this.props.multiEditSearch}
        multiAddSearch={this.props.multiAddSearch}
        multiRemoveSearch={this.props.multiRemoveSearch}
        search={this.props.search}
        leads={this.props.leads}
        getLeads={this.props.getLeads}
        clearAll={this.props.clearFilterArray}
        setLoader={this.props.setLoader}
        />
      },
      // {
        // name:"Location",
        // children:<LocationFilter
        // multiAddSearch={this.props.multiAddSearch}
        // search={this.props.search}
        // leads={this.props.leads}
        // getLeads={this.props.getLeads}
        // clearAll={this.props.clearFilterArray}
        // setLoader={this.props.setLoader}
        // countries={this.props.countries}
        // />
      // },
      // {
      //   name:"Sale Revenue",
      //   children:<RevenueFilter handleRevenue={this.props.handleRevenue} leads={this.props.leads}
      //   getLeads={this.props.getLeads} setLoader={this.props.setLoader} search={this.props.search}/>
      // },
      // {
      //   name:"Employee",
      //   children:<EmployeeFilter handleEmployee={this.props.handleEmployee} leads={this.props.leads}
      //   getLeads={this.props.getLeads} setLoader={this.props.setLoader} search={this.props.search}
      //   />
      // },
      //  {
      //   name:"Types",
      //   children:<EmployeeFilter search={this.props.search}/>
      // },
      {
        name:"By Comapny URL",
        children:<CompanyUrlFilter
        handleValue={this.props.handleValue}
        getLeads={this.props.getLeads} setLoader={this.props.setLoader} search={this.props.search}
        />
      },
      {
        name:"Company Information",
        children:<CompanyInfoFilter
        handleValue={this.props.handleValue}
        getLeads={this.props.getLeads} setLoader={this.props.setLoader}
        search={this.props.search}
        />
      },
      // {
      //   name:"Company Division",
      //   children:<FiscalYearFilter search={this.props.search}/>
      // },
      {
        name:"Fiscal Year or Starting Date",
        children:<FiscalYearFilter search={this.props.search}/>
      }
      ,
      {
        name:"Suggestion",
        children:<SuggestionInput search={this.props.search}/>
      }

    ]

    return (
      <ul  ref={this.filterLiRef}>
        { filters.map( (filter, index ) => <FilterLi key={index} onClick={(e) => this.openSubfilters(e,index) }
        active={ this.state.activeItem === index ? true : false }
        filter={filter.name} close={(e) => this.closeSubfilters(e)}
        multiAddSearch={this.props.multiAddSearch}
        search={this.props.search}
        setLoader={this.props.setLoader}
        >
        {filter.children}
        </FilterLi>)
       }

      </ul>

    );
  }


}


const mapStateToProps = state => {
  return {
    search: state.searchReducer,
    leads: state.leadsReducer.leads,
    industries: state.leadsReducer.industries,
    countries: state.leadsReducer.countries,
    isLoading:state.leadsReducer.isLoading,
    selectStates : state.selectReducer
  }
}

const mapDispactchToProps = (dispatch, ownProps ) => {
  return {
    getLeads: (leads,paginate) =>  dispatch(getLeads(leads,paginate)),
    getIndustries: (industries) =>  dispatch(getIndustries(industries)),
    getCountries: (countries) =>  dispatch(getCountries(countries)),
    setLoader: (isLoading) =>  dispatch(setLoader(isLoading)),
    handleRevenue: (value) =>  dispatch(handleRevenue(value)),
    handleEmployee: (value) =>  dispatch(handleEmployee(value)),
    toggleIndustryCategory: (value) =>  dispatch(toggleIndustryCategory(value)),
    clearFilterArray: (key) => dispatch(clearFilterArray(key)),
    handleValue: (key,value) =>  dispatch(handleValue(key,value)),
    handleToggleValue: (key,value) =>  dispatch(handleToggleValue(key,value)),

    }
  }

export default connect( mapStateToProps, mapDispactchToProps )(FilterUl);
