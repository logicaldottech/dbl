import {combineReducers} from 'redux';
import deepFreeze from 'deep-freeze';

export const initialState = {
  leads:[],
  paginate:{total:0},
  pageNumber:1,
  isLoading:false,
  industries:[],
  countries:[],
  hasStarted:false
}


function leadsReducer( state = initialState, action ){

switch( action.type ){
  case 'GET_LEADS':
  return Object.assign({}, state, {
    leads: action.leads,
    paginate:action.paginate,
    pageNumber:action.paginate.currentPage,
    ids:action.paginate.ids,
    hasStarted:true
  });
  case 'SET_LOADER':
  return Object.assign({}, state,{
    isLoading: action.isLoading
  });
  case 'GET_INDUSTRIES':
  return Object.assign({}, state, {
    industries: action.industries
  });
  case 'GET_COUNTRIES':
  return Object.assign({}, state, {
    countries: action.countries
  });
  default:
  return state;
}
}


const initialToggleState = {
  selectedLeads:[],
  allLeadSelected:false,
  isActiveFilterItem:false
}


function selectReducer( state = initialToggleState, action ){

  switch( action.type ){
    case 'TOGGLE_LEADS_SELECT':
    let selectedLeads = state.selectedLeads;
    let getIndex = selectedLeads.indexOf( action.lead_id );
    let newLeads = getIndex === -1 ? selectedLeads.concat([action.lead_id ]) : selectedLeads.filter( v => v !== action.lead_id ) ;

    return Object.assign({}, state, {
      selectedLeads: newLeads

    });

    case 'SELECT_ALL_LEADS':
    if ( state.allLeadSelected ){
    return Object.assign({}, state, {
      selectedLeads: [],
      allLeadSelected:false
    });
    } else {
      let selectLeads = [];
      action.selectedLeads.map( ( lead ) => selectLeads.push( lead.contact_id  ) );
      return Object.assign({}, state, {
        selectedLeads: selectLeads,
        allLeadSelected:true
      });
    }

    case 'HANDLE_TOGGLE_VALUE':
    return Object.assign({}, state, {
      [action.key]: action.value
    });

    default:
    return state;

  }


}

const initialSearch = {
   searchby:'contact',
   sic:[],
   naics:[],
   psc:[],
   annual_revenue:{
     min:500000,
     max:10000000000
   },
   annual_revenue:{
     min:500000,
     max:10000000000
   },
   number_of_employee:{
     min:5,
     max:10000
   },
   industry_category:[],
   industry_name:[],
   url:[],
   business_name:[],
   dba_name:[],
   perPage:10

}
function searchReducer( state = initialSearch, action ){

switch( action.type ){
  case 'MULTI_ADD_SEARCH':
  deepFreeze(state);
  let oldKey = state[action.key];
  let newKey = [...state[action.key], action.value ];
//  let uniqueNewKey = [...new Set(newKey)];
  return {...state, ...{[action.key] :newKey }}
  //return Object.assign({},state,{ sic: newKey });

  case 'MULTI_EDIT_SEARCH':
  let oldEditKey = state[action.key];
  let newEditKey = oldEditKey.filter( v => oldEditKey.indexOf(v) !== action.index ) ;
  return {...state, ...{[action.key] :newEditKey }}

  case 'MULTI_REMOVE_SEARCH':
  let oldRemoveKey = state[action.key];
  let toRemoveIndex = oldRemoveKey.lastIndexOf(action.value);
  let newRemoveKey = oldRemoveKey.filter( (v,i) => i !== toRemoveIndex ) ;
  return {...state, ...{[action.key] :newRemoveKey }}

  case 'HANDLE_REVENUE':
  return {...state, ...{annual_revenue:action.value }}

  case 'HANDLE_EMPLOYEE':
  return {...state, ...{number_of_employee:action.value }}
  case 'TOGGLE_INDUSTRY_CATEGORY':
  let thevalue = action.value;
  let splittedvalue = thevalue.split(',');
  let selected = state.industry_category;
  let getIndex = selected.indexOf( action.industry_code );
  let newSelected = getIndex === -1 ? selected.concat([action.industry_code ]) : selected.filter( v => v !== action.industry_code ) ;
  return Object.assign({}, state, {
    industry_category: newSelected
  });
  case 'CLEAR_FILTER_ARRAY':
  return Object.assign({}, state, {
    [action.filter]: []
  });

  case 'TOGGLE_SEARCH_BY':
  return  Object.assign({}, state,{
    searchby:action.value
  });

  case 'HANDLE_VALUE':
  return Object.assign({}, state, {
    [action.key]: action.value
  });
  default:
  return state;
}
}


const rootReducer = combineReducers({
  leadsReducer,
  selectReducer,
  searchReducer
});
export default rootReducer;
