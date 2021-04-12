import React from 'react';
import ReactDOM from 'react-dom';

export class SidebarButtons extends React.Component{
 constructor(props){
   super(props);

 }



  render() {
    return (
      <div className="search-sidebar-buttons">
        <button onClick={() => this.props.toggleSearchBy('contact')} className={this.props.searchby === 'contact' ? "btn active" : "btn" }>Contact</button>
        <button onClick={() => this.props.toggleSearchBy('company')} className={this.props.searchby === "company" ? "btn active" : "btn" }>Company</button>

      </div>
    );
  }


}
