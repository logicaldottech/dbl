
// Actions
export function getCountries( countries ){
  return {
    type:'GET_COUNTRIES', countries
  }
}

export function getLeads( leads, paginate ){
  return {
    type:'GET_LEADS', leads, paginate
  }
}

export function getIndustries( industries ){
  return {
    type:'GET_INDUSTRIES', industries
  }
}

export function setLoader( isLoading ){
  return {
    type:'SET_LOADER', isLoading
  }
}


export function toggleLeadSelect( lead_id ){
  return {
    type:'TOGGLE_LEADS_SELECT', lead_id
  }
}

export function selectAllLeads( selectedLeads ){
  return {
    type:'SELECT_ALL_LEADS', selectedLeads
  }
}

export function multiAddSearch( key, value ){
  return {
    type:'MULTI_ADD_SEARCH', key,value
  }
}

export function multiEditSearch( key, value,index ){
  return {
    type:'MULTI_EDIT_SEARCH', key,value,index
  }
}

export function multiRemoveSearch( key, value,index ){
  return {
    type:'MULTI_REMOVE_SEARCH', key,value,index
  }
}

  export function handleRevenue( value ){
    return {
      type:'HANDLE_REVENUE', value
    }
}

export function handleEmployee( value ){
  return {
    type:'HANDLE_EMPLOYEE', value
  }
}

export function toggleIndustryCategory( industry_code ){
  return {
    type:'TOGGLE_INDUSTRY_CATEGORY', industry_code
  }
}

export function clearFilterArray( filter ){
  return {
    type:'CLEAR_FILTER_ARRAY', filter
  }
}


export function clearFilterObject( filter ){
  return {
    type:'CLEAR_FILTER_OBJECT', filter
  }
}


export function toggleSearchBy( value ){
  return {
    type:'TOGGLE_SEARCH_BY', value
  }
}

export function handleValue( key,value ){
  return {
    type:'HANDLE_VALUE', key,value
  }
}

export function handleToggleValue( key, value ){
  return {
    type:'HANDLE_TOGGLE_VALUE', key,value
  }
}
