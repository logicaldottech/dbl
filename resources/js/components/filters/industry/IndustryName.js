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

  console.log(data);

  return inputLength === 0 ? [] : data.filter(v =>
    v.title.toLowerCase().slice(0, inputLength) === inputValue
  );
};

const getSuggestionValue = suggestion => suggestion;

const handleClicksugg = e => {
  // console.log(e.target);
  // e.stopPropagation();
  // window.alert(e.target);
}
function renderSuggestion(suggestion) {
  return (
    <span className='suggestionSpan' onClick={handleClicksugg}>{suggestion.title + " - " + suggestion.code}</span>
  );
}



export class IndustryName extends React.Component{


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
    console.log(this.props.industries)
  }
  clearAll(){
    this.setState({
      clicked:[]
    });
    this.props.clearAll('industry_name')
  }
  onChange(event, { newValue,method }){
    // event.stopPropagation();
    // console.log(event.target);
    // console.log('asdasda');
     this.setState({
       value: newValue
     });
     if( method === 'click' || method === 'enter'){
       event.preventDefault();
       event.stopPropagation();
       console.log(newValue);
       this.props.multiAddSearch('industry_name',newValue.code);
       this.setState({
         value: '',
         clicked:[...this.state.clicked,newValue.title + " - " + newValue.code]
       });
       console.log(this.state.clicked);

     }
   };



  // Autosuggest will call this function every time you need to update suggestions.
// You already implemented this logic above, so just use it.
onSuggestionsFetchRequested(valueObj){
  this.setState({
    suggestions:getSuggestions(valueObj.value,this.props.industries)
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
        placeholder: 'Type Industry Name',
        value,
        onChange: this.onChange
      };

  return (
    <div className="IndustryName">
    <div className="clearbutton"><span onClick={this.clearAll} >Clear All</span></div>
    <div className="clickedinclude">
        {
          this.state.clicked.length !== 0 &&
          this.state.clicked.map((v,index) =>
          <span key={index}>{v}</span>
        )
        }
    </div>
    <div id="autosuggestindustry">
    <Autosuggest
       suggestions={suggestions}
       onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
       onSuggestionsClearRequested={this.onSuggestionsClearRequested}
       getSuggestionValue={getSuggestionValue}
       renderSuggestion={renderSuggestion}
       inputProps={inputProps}
       // alwaysRenderSuggestions={true}
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
