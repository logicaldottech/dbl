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


export class AppTable extends React.Component{

  constructor(props){

    super(props);
    this.selectAll = this.selectAll.bind(this);
    this.state = { checked:false };

  }


  selectAll(){
    this.setState({ checked: !this.state.checked });
    console.log(this.context);
  //  store.dispatch(selectCheck(true));

  }

  render(){

    return(

      ( ! this.props.isLoading  ) ?
      <div className="table-responsive">
     <table className="table">
      <thead>
        <tr>
          <th className="as" onClick={(id) => this.props.selectAll(this.props.leads)} scope="col">{ ( this.props.allSelected ) ? <FiCheckSquare className="action-selected-icon" strokeWidth="1" /> : <FiSquare className="action-select-icon" strokeWidth="1" /> }</th>
          {
            this.props.columns.contact &&
            <th scope="col">Contact<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.dba &&
            <th scope="col">DBA Name<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.city &&
            <th scope="col">Physical City<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.phone &&
            <th scope="col">Phone<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.email &&
            <th scope="col">Email<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.naics &&
            <th scope="col">NAICS<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.sic &&
            <th scope="col">SIC<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.psc &&
            <th scope="col">PSC<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.url &&
            <th scope="col">URL<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.legal_business_name &&
            <th scope="col">Legal Business Name<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.business_start_date &&
            <th scope="col">Business Start Date<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.employee_count &&
            <th scope="col">Employee Count<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.phy_country &&
            <th scope="col">Physical Country<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.phy_state &&
            <th scope="col">Physical State<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.annual_revenue &&
            <th scope="col">Annual Revenue<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.fiscal_year &&
            <th scope="col">Fiscal Year<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }
          {
            this.props.columns.company_division &&
            <th scope="col">Company Division<FiArrowUp className="action-sort-icon" strokeWidth="1" /></th>
          }

          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody id="app-tbody">

      { this.props.leads.map( (lead, index) =>

        <AppTr key={lead.lead_id}
        id={lead.lead_id}
        contact= {lead.contacts[0].first_name + ' ' + lead.contacts[0].last_name }
        dbaname={lead.dba_name}
        email={lead.contacts[0].email_address}
        phone={lead.contacts[0].contact_phone}
        naics={lead.naics_codes}
        phy_city={lead.phy_city}
        sic={lead.psc_codes}
        psc={lead.psc_codes}
        url={lead.corporate_url}
        legal_business_name={lead.legal_business_name}
        business_start_date={lead.business_start_date}
        employee_count={lead.employee_count}
        phy_country={lead.phy_country}
        phy_state={lead.phy_state}
        annual_revenue={lead.annual_revenue}
        fiscal_year={lead.fiscal_year}
        company_division={lead.company_division}
        select={(e) => this.checkSelect(e)}
        allSelect={this.state.checked}
        toggleLead={(e) => this.props.toggleLead(lead.lead_id)}
        selected={ this.props.selected.indexOf(lead.lead_id) === -1 ? 'unchecked' : 'checked' }
        columns={this.props.columns}
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
