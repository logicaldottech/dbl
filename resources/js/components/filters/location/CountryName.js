import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import {ApplyFilter} from './../ApplyFilter';
import axios from 'axios';
import {APP_URL} from '../../../constants/site';
import {FiSquare,FiCheckSquare} from "react-icons/fi";
import Autosuggest from 'react-autosuggest';


const getSuggestions = (value,data) => {
  const inputValue = value.trim().toLowerCase();
  const inputLength = inputValue.length;
  console.log(value);
  console.log(data);
  console.log("name data");
  return inputLength === 0 ? [] : data.filter(country =>
    country.name.toLowerCase().slice(0, inputLength) === inputValue
  );
};

const getSuggestionValue = suggestion => suggestion;

function renderSuggestion(suggestion) {
  return (
    <span>{suggestion.name + " - " + suggestion.alpha_3}</span>
  );
}



export class CountryName extends React.Component{


  constructor(props){
    super(props);

    this.state = {
      isLoading:true,
      value: '',
      suggestions: [],
      clicked:[]

    }

    this.onChange = this.onChange.bind(this);
    this.onSuggestionsFetchRequested = this.onSuggestionsFetchRequested.bind(this);
    this.onSuggestionsClearRequested = this.onSuggestionsClearRequested.bind(this);
    this.checktest = this.checktest.bind(this);
    this.clearAll = this.clearAll.bind(this)
  }

  checktest(){
    console.log(this.props.countries)
  }
  clearAll(){
    this.setState({
      clicked:[]
    });
    this.props.clearAll('country_name')
  }
  onChange(event, { newValue,method }){
     this.setState({
       value: newValue
     });
     if( method === 'click' || method === 'enter'){
       console.log(newValue);
       this.props.multiAddSearch('country_name',newValue.name);
       this.setState({
         value: '',
         clicked:[...this.state.clicked,newValue.name + " - " + newValue.alpha_3]
       });
       console.log(this.state.clicked);

     }
   };



  // Autosuggest will call this function every time you need to update suggestions.
// You already implemented this logic above, so just use it.
onSuggestionsFetchRequested(valueObj){
  this.setState({
    suggestions:getSuggestions(valueObj.value,this.props.countries)
  });
};

//  Autosuggest will call this function every time you need to clear suggestions.
onSuggestionsClearRequested(){
  this.setState({
    suggestions: []
  });
};

  render() {

    const { value, suggestions } = this.state;

      // Autosuggest will pass through all these props to the input.
      const inputProps = {
        placeholder: 'Type Country Name',
        value,
        onChange: this.onChange
      };

  return (
    <div className="CountryName">
    <div className="clearbutton"><span onClick={this.clearAll} >Clear All</span></div>
    <div className="clickedinclude">
        {
          this.state.clicked.length !== 0 &&
          this.state.clicked.map((v,index) =>
          <span key={index}>{v}</span>
        )
        }
    </div>
    <div id="autosuggestCountry">
    <Autosuggest
       suggestions={suggestions}
       onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
       onSuggestionsClearRequested={this.onSuggestionsClearRequested}
       getSuggestionValue={getSuggestionValue}
       renderSuggestion={renderSuggestion}
       inputProps={inputProps}
     />
     </div>
    <ApplyFilter
      search={this.props.search}
      setLoader={this.props.setLoader}
      getLeads={this.props.getLeads}
     />
    </div>
  );

  }


}
