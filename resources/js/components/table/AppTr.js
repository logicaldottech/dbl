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

    console.log(user_id_login);

    axios({
      method:'post',
      url:APP_URL + '/get-credits',
      data:{type:"json", id:ids}
    }).then( res =>{
      console.log("success");
        console.log(res);
      if (res.data === true) {

        window.open(APP_URL + '/export-excel?ids=['+ids+']', "_self" );

      }else{

        swal({
          title: "Error!",
          text: "You don't have enough credits. Please Refill Your Credits",
          icon: "error",
          button: "Ok",
        });
      }

      })
      .catch( error => {
        console.log("error");
        console.log(error);
      });
//end axios

  }

  render(){
    return (
        <tr>
        <th className={this.props.selected} scope="row"
        onClick={this.props.toggleLead}>
        { ( this.props.selected === 'checked' ) ? <FiCheckSquare className="action-selected-icon" strokeWidth="1" /> : <FiSquare className="action-select-icon" strokeWidth="1" /> }
        </th>
        { this.props.columns.contact && <td className="tdbig">{this.props.contact}</td> }
        { this.props.columns.dba && <td className="tdmedium">{this.props.dbaname}</td> }
        { this.props.columns.city && <td className="tdmedium">{this.props.phy_city}</td> }
        { this.props.columns.phone && <td className="tdmedium">{this.props.phone}</td> }
        { this.props.columns.email && <td className="tdbig">{this.props.email}</td> }
        { this.props.columns.naics && <td className="codetd"><ViewMore data={this.props.naics}/></td> }
        { this.props.columns.psc && <td className="codetd"><ViewMore data={this.props.psc}/></td> }
        { this.props.columns.url && <td className="tdmedium">{this.props.url}</td> }
        { this.props.columns.legal_business_name && <td className="tdbig">{this.props.legal_business_name}</td> }
        { this.props.columns.business_start_date && <td className="tdsmall">{this.props.business_start_date}</td> }
        { this.props.columns.phy_country && <td className="tdsmall">{this.props.phy_country}</td> }
        { this.props.columns.phy_state && <td className="tdsmall">{this.props.phy_state}</td> }
        { this.props.columns.fiscal_year && <td className="tdsmall">{this.props.fiscal_year}</td> }
        <td><FiDownload onClick={(ids,lead_ids) => this.props.downloadFormclick( this.props.contact_id,this.props.id)} className="action-download-icon" strokeWidth="2" /></td>
        </tr>
    );
  };

}
