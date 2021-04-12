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


function selectReducer( state = {selectedLeads:[]},action ){

  switch( action.type ){
    case 'TOGGLE_LEADS_SELECT':
    let lead_id = action.lead_id;
    let selectedLeads = state.selectedLeads;
    let getIndex = selectedLeads.indexOf( lead_id );
    let i = getIndex > -1 ? selectedLeads.splice( getIndex, 1) : selectedLeads.push(lead_id);
    let as = selectedLeads;
    return Object.assign({}, state, {
      selectedLeads: selectedLeads

    });

    case 'SELECT_ALL_LEADS':
    if ( state.selectedLeads.length ){
    return Object.assign({}, state, {
      selectedLeads: []
    });
    } else {
      let selectLeads = [];
      action.selectedLeads.map( ( lead ) => selectLeads.push( lead.lead_id  ) );
      return Object.assign({}, state, {
        selectedLeads: selectLeads
      });
    }

    default:
    return state;

  }


}

const rootReducer = combineReducers({
  leadsReducer,
  selectReducer
});
export default rootReducer;
