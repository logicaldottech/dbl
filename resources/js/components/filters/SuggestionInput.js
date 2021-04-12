import React from 'react';
import ReactDOM from 'react-dom';
import {APP_URL} from '../../constants/site';
import axios from 'axios';
import swal from 'sweetalert';
import Autosuggest from 'react-autosuggest';
import {ApplyFilter} from './ApplyFilter';
import {FiSquare,FiCheckSquare} from "react-icons/fi";




export class SuggestionInput extends React.Component{

    constructor(props){
      super(props);

      this.state = {
            value: '',
            suggestions: [],
            isLoading:false,
            clicked:[]

          };

          this.onChange = this.onChange.bind(this);
          this.onSuggestionsFetchRequested = this.onSuggestionsFetchRequested.bind(this);
          this.onSuggestionsClearRequested = this.onSuggestionsClearRequested .bind(this);
          this.clearAll = this.clearAll.bind(this)
          this.renderSuggestion = this.renderSuggestion.bind(this)

    }

    clearAll(){
      this.setState({
        clicked:[]
      });
    //  this.props.clearAll('industry_name')
    }

    onChange(event, { newValue,method }){
        this.setState({
          value: newValue,
        });
        if( method === 'click' || method === 'enter'){
          let oldClick = this.state.clicked;
          let newClick = [...oldClick,newValue]
          this.setState({
            value: '',
            clicked:[...new Set(newClick)]
          });
          console.log(this.state.clicked);

        }
        console.log(this.state);
      };



    getSuggestions(value){
      let inputValue = value;
      let inputLength = inputValue.length;
      return 's';
      return inputLength === 0 ? [] : languages.filter(lang =>
        lang.name.toLowerCase().slice(0, inputLength) === inputValue
      );

    }

    getSuggestionValue( suggestion ){
      return suggestion.name;
    }

    renderSuggestion( suggestion ){

      return (

        <span className='suggestionSpan'>
        {this.state.clicked.indexOf(suggestion.name) === -1 ?
          <FiSquare/>
          :
          <FiCheckSquare/>
        }
        {suggestion.name}
        </span>
    );

    }

    onSuggestionsFetchRequested(typedvalue){
      console.log(typedvalue);
      this.setState({isLoading:true});
      axios.get('/api/getcountries?value='+typedvalue.value)
      .then( res =>{
          console.log(res.data);
          this.setState({
            suggestions: res.data,
            isLoading:false
          });
      })
        .catch( error => {
          console.log(error);
        });




    };

    onSuggestionsClearRequested(){
    this.setState({
      suggestions: []
    });
  };

    render() {

      const { value } = this.state;

      const inputProps = {
          placeholder: 'Type a programming language',
          value,
          onChange: this.onChange
        };
    let suggestions = [
      {
        name: 'C',
        year: 1972
      },
      {
        name: 'Elm',
        year: 2012
      }
    ]

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
        suggestions={this.state.suggestions}
        onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
        onSuggestionsClearRequested={this.onSuggestionsClearRequested}
        getSuggestionValue={this.getSuggestionValue}
        renderSuggestion={this.renderSuggestion}
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
