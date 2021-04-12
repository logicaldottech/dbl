import {combineReducers} from 'redux';

// reducer
export const initialState = {
  leads:[],
  pageNumber:1,
}


function leadsReducer( state = initialState, action ){

switch( action.type ){
  case 'GET_LEADS':
  return Object.assign({}, state, {
    leads: action.leads
  });
  default:
  return state;
}
}


function selectReducer( state = {selectedLeads:[],allLeadSelected:false},action ){

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
      action.selectedLeads.map( ( lead ) => selectLeads.push( lead.lead_id  ) );
      return Object.assign({}, state, {
        selectedLeads: selectLeads,
        allLeadSelected:true
      });
    }

    default:
    return state;

  }


}

const initialSearch = {
   sic:[],
   psc:[],
   naics:[]
}
function searchReducer( state = initialSearch, action ){

switch( action.type ){
  case 'MULTI_ADD_SEARCH':
  let oldKey = state[action.key];
  let newKey = [...state[action.key], action.value ];
//  let uniqueNewKey = [...new Set(newKey)];
  //return {...state, ...{[action.key] :newKey }}
  return Object.assign({},state,{ sic: [23] });

  case 'MULTI_EDIT_SEARCH':
  let oldEditKey = state[action.key];
  let newEditKey = oldEditKey.filter( v => oldEditKey.indexOf(v) !== action.index ) ;
  return {...state, ...{[action.key] :newEditKey }}

  case 'MULTI_REMOVE_SEARCH':
  let oldRemoveKey = state[action.key];
  let toRemoveIndex = oldRemoveKey.lastIndexOf(action.value);
  let newRemoveKey = oldRemoveKey.filter( (v,i) => i !== toRemoveIndex ) ;
  return {...state, ...{[action.key] :newRemoveKey }}


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
