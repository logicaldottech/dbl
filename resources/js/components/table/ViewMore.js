import React from 'react';
import ReactDOM from 'react-dom';
import {FiChevronDown} from "react-icons/fi";

export class ViewMore extends React.Component{

  constructor(props){

    super(props);
    this.state = { view:false };
    this.toggleView = this.toggleView.bind(this);
  }


  toggleView(e){

    e.preventDefault();
    this.setState( state => ({view: !state.view }) );
  }

  render(){

    return(

       this.props.data.length > 0
        ?
        <div className="ViewMore">
        {
           ! this.state.view &&
            this.props.data.slice(0,2).map( (v,k ) => (
             v != 0 && <span key={k}>{v}</span>
           ))
        }
        {
           this.state.view &&
            this.props.data.map( (v,k ) => (
              v != 0 && <span key={k}>{v}</span>
          ))
        }
        <div className="links">
        { ! this.state.view && this.props.data.length > 2 && <a onClick={(e) => this.toggleView(e) }href="#">View More...</a> }
        {  this.state.view && <a onClick={(e) => this.toggleView(e) }href="#">View Less</a> }
        </div>
        </div>
        :
        <div>

        </div>

    )
   }

}
