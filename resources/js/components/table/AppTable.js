import React from 'react';
import ReactDOM from 'react-dom';
import { FiSquare } from "react-icons/fi";
import {FiArrowUp} from "react-icons/fi";
import {FiArrowDown} from "react-icons/fi";
import {FiDownload} from "react-icons/fi";
import axios from 'axios';
import {AppTr} from './AppTr';
import {Loader} from '../Loader';
import {AppPagination} from './AppPagination';
import {FiCheckSquare} from "react-icons/fi";
//import {store} from '../../store.js';
import {selectCheck, selectAllLeads} from '../../actions';
import {APP_URL} from '../../constants/site';
import {saveAs} from "file-saver";


export class AppTable extends React.Component{

  constructor(props){

    super(props);
    this.selectAll = this.selectAll.bind(this);
    this.state = { checked:false };
    this.downloadFormclick = this.downloadFormclick.bind(this);

  }


  selectAll(){
    this.setState({ checked: !this.state.checked });
    console.log(this.context);
  //  store.dispatch(selectCheck(true));

  }

  downloadFormclick( ids,lead_ids ){

    swal({
        title: "Are you sure?",
        text: "You Are About To Download 1 Number Of Leads And Spend 1 Number Of Credits",
        icon: "info",
        buttons: {
          cancel: "Cancel",
          save: {
            text: "Confirm",
            value: "save",
            closeModal: false,
          },
        },
      })
      .then((value) => {

        if (value) {

          axios({
            method:'post',
            url:APP_URL + '/get-credits-contact',
            data:{id:ids},
          }).then( res =>{
            console.log("success");
              console.log(res);
            if (res.data === true) {

              axios({
                method:'post',
                url:APP_URL + '/export-excel-contacts',
                responseType: 'blob',
                data:{ids:[ids],lead_ids:[lead_ids]}
              }).then( res =>{
                saveAs(new Blob([res.data]),'DBL' + ids + Date.now() + '.csv');
                console.log(res);
              }).catch(error =>{
                console.log("error down");
                console.log(error);
              });
              // end axios inner
              swal.stopLoading();
              swal.close();
            } // end if
            else{

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
            }); //end axios upper

        }else {
         swal.close();
       } // end else
      });
    // end swal confirmation

  }




  render(){

    return(

      ( ! this.props.isLoading  ) ?
      <div className="table-responsive">
     <table className="table table-fixed">
      <thead>
        <tr>
          <th className="as" onClick={(id) => this.props.selectAll(this.props.leads)} scope="col">{ ( this.props.allSelected ) ? <FiCheckSquare className="action-selected-icon" strokeWidth="1" /> : <FiSquare className="action-select-icon" strokeWidth="1" /> }</th>
          {
            this.props.columns.contact &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuContact" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Contact
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuContact">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.dba &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuDba" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                DBA Name
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuDba">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.city &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuCity" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Physical City
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuCity">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.phone &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuPhone" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Phone
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuPhone">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.email &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuEmail" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Email
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuEmail">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.naics &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuNaics" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                NAICS
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuNaics">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.psc &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuPsc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                PSC
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuPsc">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.url &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuUrl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                URL
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuUrl">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.legal_business_name &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuLegal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Legal Business Name
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuLegal">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.business_start_date &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuBusinessDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Business Start Date
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuBusinessDate">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.phy_country &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuCountry" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Physical Country
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuCountry">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.phy_state &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuState" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Physical State
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuState">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }
          {
            this.props.columns.fiscal_year &&
            <th className="dropdown">
              <span className="dropdown-toggle" id="dropdownMenuFiscal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Fiscal Year
              </span>
              <span className="dropdown-menu" aria-labelledby="dropdownMenuFiscal">
                <button className="dropdown-item" type="button">SORT A-Z</button>
                <button className="dropdown-item" type="button">SORT Z-A</button>
              </span>
            </th>
          }


          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody id="app-tbody">

      { this.props.leads.map( (lead, index) =>

        <AppTr
        key={lead.contact_id}
        id={lead.lead_id}
        contact_id={lead.contact_id}
        contact= {lead.name }
        dbaname={lead.dba_name}
        email={lead.email}
        phone={lead.contact_phone}
        naics={lead.naics_codes}
        phy_city={lead.physical_cities}
        psc={lead.psc_codes}
        url={lead.url}
        legal_business_name={lead.legal_business_name}
        business_start_date={lead.business_start_date}
        phy_country={lead.physical_countries}
        phy_state={lead.physical_state}
        fiscal_year={lead.fiscal_year}
        company_division={lead.company_division}
        select={(e) => this.checkSelect(e)}
        allSelect={this.state.checked}
        toggleLead={(e) => this.props.toggleLead(lead.contact_id)}
        selected={ this.props.selected.indexOf(lead.contact_id) === -1 ? 'unchecked' : 'checked' }
        columns={this.props.columns}
        downloadFormclick={(ids,lead_ids) => this.downloadFormclick(ids,lead_ids)}
        />

       )

      }

      </tbody>
      </table>
      </div>
      :
      <div className="table-loader-div">
      <div className="loaderdiv">
      <Loader/>
      </div>
      </div>


   );
  }

}
