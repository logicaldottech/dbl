import React, { Component } from "react";

class ToggleSwitch extends Component {


  constructor(props){
    super(props);

    this.state = {
      checked: false
    }

    this.handleCheck = this.handleCheck.bind(this);

  }

  handleCheck(){
    this.setState( (prevstate) => ( { checked : !prevstate.checked}));

    console.log(this.state.checked);
  }
  render() {
    return (
      <div className="toggle-switch">

        <label className="switch" htmlFor={this.props.Name}>
          <input
          type="checkbox"
          className="switch-checkbox"
          name={this.props.Name}
          id={this.props.Name} onChange = {() => this.handleCheck() } checked ={this.state.checked}
        />
          <span className="switch-slider switch-round" />
        </label>
      </div>
    );
  }
}

export default ToggleSwitch;
