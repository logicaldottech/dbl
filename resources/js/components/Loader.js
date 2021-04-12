import React from 'react';
import ReactDOM from 'react-dom';

export class Loader extends React.Component{

  constructor(props){

    super(props);

  }
  
  render(){
    return (
      <svg id="logoicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 386.32 410.11"><title>animsingle</title><path id="blackpart" className="cls-1" d="M640.6,564.81V195c-66.26-8.3-128.15-21.15-162.54-21.15v156L583.19,435l21.06,21.07V584C613.29,575.87,626.29,569.83,640.6,564.81Z" transform="translate(-478.06 -173.89)"/><path id="orangepart" className="cls-2" d="M663.85,197.26V558.81c36.63-10.64,74.35-18,74.35-37.9V456.06L864.39,329.87v-156C816.52,205.8,738.82,205.42,663.85,197.26Z" transform="translate(-478.06 -173.89)"/></svg>
    );
  };

}
