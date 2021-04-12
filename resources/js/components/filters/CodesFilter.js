import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck, FiEdit2 } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import { FiChevronUp } from "react-icons/fi";
import { FiPlus } from "react-icons/fi";
import { FiMinus } from "react-icons/fi";
import swal from 'sweetalert';

import { MdEdit } from "react-icons/md";

export class CodesFilter extends React.Component{
 constructor(props){


   super(props);
   this.state = { Inputs:[{key:1,status:'empty',value:''}],values:[],change:'' };
   this.addCodeInputs = this.addCodeInputs.bind(this);
   this.removeCodeInputs = this.removeCodeInputs.bind(this);
   this.handleChange = this.handleChange.bind(this);
   console.log(this.props.multiAddSearch);
   this.tick = this.tick.bind(this);
   this.edit = this.edit.bind(this);
   this.clearAll = this.clearAll.bind(this)

 }

 clearAll(){
   this.setState({
    Inputs:[{key:1,status:'empty',value:''}]
   });
   let inputId = this.props.name + '-' + 1;
   document.getElementById(inputId).value = '';

   this.props.clearAll(this.props.name)
 }

 addCodeInputs(){

   var curInputs = this.state.Inputs.length + 1;
   var stateArr = this.state.Inputs;
   stateArr.push( {key:curInputs,status:'empty',value:''});
   this.setState((state,props) => ({ Inputs: stateArr
   }) );
   //console.log(curInputs);
  // console.log(this.state.Inputs);

 }

 removeCodeInputs(){

   var curInputs = this.state.Inputs.length - 1;
   var stateArr = this.state.Inputs;

   let inputId = this.props.name + '-' + this.state.Inputs.length;
   let inputValue = document.getElementById(inputId).value;

   if ( inputValue.length > 0 ){
     this.props.multiRemoveSearch(this.props.name,inputValue,curInputs);
   }
     stateArr.pop( curInputs );
     this.setState((state,props) => ({ Inputs: stateArr
     }) );

   //console.log(curInputs);
   //console.log(this.state);


 }

 handleChange(event){
   //console.log(event.target.value);
   let value = event.target.value;
   let key = event.target.getAttribute('data-key');
   if ( this.handleValidation(value) === true ){
     //console.log('Valid');
     event.target.style.outlineColor = '#3f9ae5';

   } else {
     //console.log('Invalid ' + value.length);
     event.target.style.outlineColor = "red";
   }
 }

 handleValidation(value){

   switch(this.props.name){
     case 'sic':
     if ( value.length <= 4 && value.length > 0 &&  /^\d+$/.test(value) ){
       return true;
     } else {
       return 'You have entered an invalid SIC code. Please enter 1 to 4 digit SIC code.';
     }
     case 'naics':
     if ( value.length === 6  &&  /^\d+$/.test(value) ){
       return true;
     } else {
       return 'You have entered an invalid NAICS code. Please enter 6 digit NAICS code.';
     }

     case 'psc':
     if ( value.length === 4 && value.length > 0 ){
       return true;
     } else {
       return 'You have entered an invalid PSC code. Please enter 4 digit PSC Code.';
     }
     default:
     return true;
   }
 }

 handleErorMessage(code,min,max){

 }

 tick(key){

   let inputId = this.props.name + '-' + key;
   let inputValue = document.getElementById(inputId).value;

   if ( this.handleValidation(inputValue)  === true ){
     this.setState( (state) => {
       let newInputs = this.state.Inputs.map((value,index) => {
         if ( index + 1 === key ){
           value = {key:key,status:'checked',value:inputValue}
         }
         return value;
       });
       return {Inputs:newInputs }
     });

     this.props.multiAddSearch(this.props.name,inputValue);
   } else {
     swal('Invalid', this.handleValidation(inputValue),'error');
   }

   console.log(this.state);


 }

 edit(key){

      let inputId = this.props.name + '-' + key;
      let inputValue = document.getElementById(inputId).value;
      this.setState( (state) => {
        let newInputs = this.state.Inputs.map((value,index) => {

          if ( index + 1 === key ){
            value = {key:key,status:'edit'}
          //  console.log(key);
          }
          return value;
        });

        return {Inputs:newInputs }
      });

      this.props.multiEditSearch(this.props.name,inputValue,key-1);

      //console.log(this.state);
 }

  render() {

    const removeButton = <div onClick={this.removeCodeInputs} className="addmorebtn">
    <FiMinus/><span>&nbsp;Remove</span>
    </div>;

    return (
      <div>
      <div className="clearbutton"><span onClick={this.clearAll} >Clear All</span></div>
      <p>Enter {this.props.code} Code below</p>
      <div className="clickedinclude">
          {
            this.state.Inputs.map((v,index) =>
             v.status === 'checked'
              &&
              <span key={index}>{v.value}</span>
          )
          }
      </div>
        <form>
        <div className="codeInputs">
        {this.state.Inputs.map( (input) =>
          <div key={input.key} className="codeInputsDiv">
          <input id={this.props.name + '-' + input.key } className="input-control filter-input-text" type="text"
          name={this.props.name + '[]'}
          onChange={this.handleChange}
          data-key={input.key}
          disabled={ input.status === 'checked'  }
           />
           <div className="codeInputsIcon">
           <FiCheck onClick={ (key) => this.tick(input.key) }
           className={ input.status === 'checked' ? 'd-none' : 'check' } />
           <MdEdit onClick={ (key) => this.edit(input.key) }
           className={input.status === 'checked' ? 'edit' : 'd-none' } />
           </div>
           </div>
        )}
        </div>
        </form>
        { this.state.Inputs.length > 1 && removeButton }
        <div onClick={this.addCodeInputs} className="addmorebtn">
        <FiPlus/><span>&nbsp;Add</span>
        </div>

      </div>
    );
  }


}
