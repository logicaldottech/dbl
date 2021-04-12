import React from 'react';
import ReactDOM from 'react-dom';
import { FiSquare } from "react-icons/fi";

import {FiDownload} from "react-icons/fi";


export class AppTr extends React.Component{

  constructor(props){

    super(props);

  }




  render(){
    return (
        <tr>
        <th scope="row"><FiSquare className="action-select-icon" strokeWidth="1" /></th>
        <td>{this.props.contact}</td>
        <td>{this.props.dbaname}</td>
        <td><div className="naicstd">
        {this.props.naics_codes.map( (code) =>
          (code !== 0 ?
            <span>{code}&nbsp;</span>
             : ''
           )
         )}
         </div></td>
        <td>{this.props.phone}</td>
        <td>{this.props.email}</td>
        <td><FiDownload className="action-download-icon" strokeWidth="2" /></td>
        </tr>
    );
  };

}
