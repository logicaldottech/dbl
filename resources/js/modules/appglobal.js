import {store} from '../store.js';
import {handleToggleValue}  from '../actions';



/**
Window Click Listener Function to toggle off opened
menus.
If condition so that only work on app page

First function is declared then applied.
*/


export const appliedFiltershow = ( filters ) => {

  let appliedFilters = {};
  if ( filters.naics.length !== 0 ) {
    appliedFilters =  Object.assign({}, appliedFilters, {
      naics: filters.naics
    });
  }
  return appliedFilters;
}
