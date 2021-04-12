import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import { FiChevronDown } from "react-icons/fi";
import { FiChevronUp } from "react-icons/fi";
import { FiPlus } from "react-icons/fi";
import { FiMinus } from "react-icons/fi";


export class CodesFilter extends React.Component{
 constructor(props){


   super(props);
   this.state = { Inputs:[1],change:'' };
   this.addCodeInputs = this.addCodeInputs.bind(this);
   this.removeCodeInputs = this.removeCodeInputs.bind(this);
   this.handleChange = this.handleChange.bind(this);
   console.log(this.props.multiAddSearch);

 }

 addCodeInputs(){

   var curInputs = this.state.Inputs.length + 1;
   var stateArr = this.state.Inputs;
   stateArr.push( curInputs );
   this.setState((state,props) => ({ Inputs: stateArr
   }) );
   console.log(curInputs);
   console.log(this.state.Inputs);

   this.props.multiAddSearch('sic',[1212]);
 }

 removeCodeInputs(){

   var curInputs = this.state.Inputs.length - 1;
   var stateArr = this.state.Inputs;
     stateArr.pop( curInputs );
     this.setState((state,props) => ({ Inputs: stateArr
     }) );

   console.log(curInputs);
   console.log(this.state.Inputs);
   this.props.multiAddSearch('pic',[1212]);

 }

 handleChange(event){
   //console.log(event.target.value);
   let value = event.target.value;
   if ( value.length <= 4 && value.length > 0  ){
     console.log('Valid');
     console.log(value.length);

   } else {
     console.log('Invalid ' + value.length);
     event.target.style.border = "1px solid red";
   }
 }

  render() {

    const removeButton = <div onClick={this.removeCodeInputs} className="addmorebtn">
    <FiMinus/><span>&nbsp;Remove</span>
    </div>;

    return (
      <div>
      <p>Enter {this.props.code} Code below</p>
        <form>
        <div className="codeInputs">
        {this.state.Inputs.map( (key) =>
          <input key={key} className="input-control filter-input-text" type="text"
          name={this.props.name + '[]'}
          onChange={this.handleChange}
           />
        )}
        </div>
        </form>
        { this.state.Inputs.length > 1 && removeButton }
        <div onClick={this.addCodeInputs} className="addmorebtn">
        <FiPlus/><span>&nbsp;Add More</span>
        </div>

      </div>
    );
  }


}
