import React from 'react';
import ReactDOM from 'react-dom';
import { FiSquare } from "react-icons/fi";

import {FiDownload} from "react-icons/fi";
import {FaEye} from "react-icons/fa";
import {FiCheckSquare} from "react-icons/fi";

import {ViewMore} from "./ViewMore";
import {APP_URL} from '../../constants/site';

import swal from 'sweetalert';
import axios from 'axios';

export class AppTr extends React.Component{

  constructor(props){

    super(props);
    this.checkSelect = this.checkSelect.bind(this);
    this.state = { checked:false};
    this.download = this.download.bind(this);

  }



  checkSelect(e,f){



    //this.setState({ checked: ! this.state.checked });
    //this.setState({ allSelect: ! f });
    this.setState(function(state, props) {
      console.log( "This is checked state " + state.checked  );
      console.log( "This is allSelect state " + state.allSelect  );
      console.log( "This is prop " + f  );

    return {
    checked: ! state.checked,
    allSelect: ! f
    };
  });
    //console.log( "This is allSelect state " + this.state.allSelect  );
    //console.log( "This is prop " + f  );

  }

  download( ids ){

    // window.open(APP_URL + '/api/export-excel?id='+id, "_self" );
    // let params = { id:id }
    let id = ids;
    // this.props.setLoader(true);
    console.log(ids);
    axios({
      method:'post',
      url:APP_URL + '/api/export-excel',
      data:{id:id}
    }).then( res =>{
      console.log("success");
        console.log(res);
        // this.props.setLoader(false);

      })
      .catch( error => {
        console.log("error");
        console.log(error);
      });
  }

  render(){
    return (
        <tr>
        <th className={this.props.selected} scope="row"
        onClick={this.props.toggleLead}>
        { ( this.props.selected === 'checked' ) ? <FiCheckSquare className="action-selected-icon" strokeWidth="1" /> : <FiSquare className="action-select-icon" strokeWidth="1" /> }
        </th>
        { this.props.columns.contact && <td>{this.props.contact}</td> }
        { this.props.columns.dba && <td>{this.props.dbaname}</td> }
        { this.props.columns.city && <td>{this.props.phy_city}</td> }
        { this.props.columns.phone && <td>{this.props.phone}</td> }
        { this.props.columns.email && <td>{this.props.email}</td> }
        { this.props.columns.naics && <td className="codetd"><ViewMore data={this.props.naics}/></td> }
        { this.props.columns.sic && <td className="codetd"><ViewMore data={this.props.sic}/></td> }
        { this.props.columns.psc && <td className="codetd"><ViewMore data={this.props.psc}/></td> }
        { this.props.columns.url && <td>{this.props.url}</td> }
        { this.props.columns.legal_business_name && <td>{this.props.legal_business_name}</td> }
        { this.props.columns.business_start_date && <td>{this.props.business_start_date}</td> }
        { this.props.columns.employee_count && <td>{this.props.employee_count}</td> }
        { this.props.columns.phy_country && <td>{this.props.phy_country}</td> }
        { this.props.columns.phy_state && <td>{this.props.phy_state}</td> }
        { this.props.columns.annual_revenue && <td>{this.props.annual_revenue}</td> }
        { this.props.columns.fiscal_year && <td>{this.props.fiscal_year}</td> }
        { this.props.columns.company_division && <td>{this.props.company_division}</td> }
        <td><FaEye className="action-view-icon" strokeWidth="2" /></td>
        <td><FiDownload onClick={(id) => this.download( this.props.id)} className="action-download-icon" strokeWidth="2" /></td>
        </tr>
    );
  };

}
