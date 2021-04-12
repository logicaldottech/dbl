import React from 'react';
import ReactDOM from 'react-dom';
import { FiSquare ,FiCheckSquare} from "react-icons/fi";
import {FiArrowUp} from "react-icons/fi";
import {FiArrowDown} from "react-icons/fi";
import {FiDownload} from "react-icons/fi";
import axios from 'axios';
import {AppTr} from './AppTr';
import {Loader} from '../Loader';
import {AppPagination} from './AppPagination';
import {AppTable} from './AppTable';
import {store} from '../../store.js';
import {handleValue,selectCheck,getLeads,selectAllLeads,toggleLeadSelect,setLoader}  from '../../actions';
import { connect } from 'react-redux';
import {APP_URL} from '../../constants/site';



 class AppDiv extends React.Component{

  constructor(props){

    super(props);
    const columns = {
      naics:true,
      psc:false,
      dba:false,
      city:false,
      contact:true,
      phone:true,
      email:true,
      url:true,
      legal_business_name: true,
      business_start_date: false,
      phy_country: false,
      phy_state: false,
      fiscal_year: false,

    }
    this.state = { columns:columns,showEditColumns:false,
       isLoading:true, leads:['a'], paginate:'',
       showDownloadMenu:false,
       leadExportFrom:"",
       leadExportTo:"",
       exportIds:[]
     };

    this.pageChange = this.pageChange.bind(this);
    this.goToPage = this.goToPage.bind(this);

    this.editColumns = this.editColumns.bind(this);
    this.toggleEditColumn = this.toggleEditColumn.bind(this);
    this.toggleDownloadMenu = this.toggleDownloadMenu.bind(this);
    this.handleOutsideClickEdit = this.handleOutsideClickEdit.bind(this);
  }

  componentDidMount() {

    this.props.setLoader(true);

    let query = {...this.props.search,...{page:1}};

    axios({
      method:'post',
      url:APP_URL + '/api/search',
      data:{}
    }).then( res =>{
        console.log(res.data);
        this.props.getLeads(res.data.leads,res.data.paginate);

        this.props.setLoader(false);

      })
      .catch( error => {
        console.log(error);
      });

  }

  loadPaginateRecords( pageNumber,perPage=10 ){

    let query = {...this.props.search,...{page:pageNumber,perPage:perPage}};
    this.props.setLoader(true);

    axios({
      method:'post',
      url:APP_URL + '/api/search',
      data:query
    }).then( res =>{
        console.log(res.data);
        this.props.getLeads(res.data.leads,res.data.paginate);

        this.props.setLoader(false);

      })
      .catch( error => {
        console.log(error);
      });
  }

  pageChange(e,pageNumber){
    console.log(pageNumber);

   console.log(e.selected);
  // this.loadPaginateRecords(e.selected);
 }

 goToPage( pageNumber,perPage=10 ){
   console.log(perPage);
   window.alert('as');
   return;
// this.loadPaginateRecords(pageNumber,perPage);
 }

 editColumns(e,column){
   e.preventDefault();

   let updateColumns = Object.assign({},this.state.columns,{[column] : ! this.state.columns[column]});
   this.setState({columns:updateColumns});
   console.log(this.state.columns);


 }
// csv download all
 downloadAll(e){

   window.open(APP_URL + '/api/export-excel', "_self" );

 }

// csv download custom
 downloadSelected(e){

    let ids = [1,2,3,4];

    var idsLength = ids.length;
    console.log(idsLength);
    // var user_id_login = document.getElementById('user_id_login').value;

    swal({
        title: "Are you sure?",
        text: "You Are About To Download "+ idsLength +" Number Of Leads And Spend "+ idsLength +" Number Of Credits",
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
              console.log(res.data);
            if (res.data === true) {
              axios({
                method:'post',
                url:APP_URL + '/export-excel-contacts',
                responseType: 'blob',
                data:{ids:ids}
              }).then( res =>{
                saveAs(new Blob([res.data]),'DBL' + ids + Date.now() + '.csv');
                console.log(res);
              }).catch(error =>{
                console.log("error down");
                console.log(error);
              });
              swal.stopLoading();
              swal.close();
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

        } //end if
        else {

          swal.close();

        } // end else

      }); //end swal


 }

 toggleEditColumn(){
   this.setState( (state) => ({ showEditColumns: !state.showEditColumns }) );
   console.log(this.state.showEditColumns);

   // this.state.showEditColumns ? document.removeEventListener('mousedown', this.handleOutsideClick, false)
   // :
   document.addEventListener('mousedown', this.handleOutsideClickEdit, false);

     //document.addEventListener('mousedown', this.handleOutsideClickEdit, false);
 }


handleOutsideClickEdit(e){
  console.log(e.target);
  console.log('toogleeeeeee');
  let targeted1 = e.target.closest('.edit-columns');
  let targeted2 = e.target.closest('.download-button');

  if ( targeted1 !== null || targeted2 !== null
 ){
    console.log('yes')
  } else {
    console.log('no')
    this.setState(
      {  showEditColumns: false,showDownloadMenu:false });
    // this.setState(
    //   {  activeItem: false });
    document.removeEventListener('mousedown', this.handleOutsideClickEdit, false);

  }
}
 toggleDownloadMenu(){
   this.setState( (state) => ({ showDownloadMenu: !state.showDownloadMenu }) );
   console.log(this.state.showEditColumns);
   document.addEventListener('mousedown', this.handleOutsideClickEdit, false);

 }

  render(){
    return(
      <div>
      {
          this.props.leads.length !== 'asdsda' &&

      <div>


      <div id="app-main-table" className="app-main-table">

      <div className="app-table-header">
      <div className="dropdown edit-columns">
        <button className="btn dropdown-toggle" type="button"
        onClick={ this.toggleEditColumn }
        id="dropdownMenuButton"
        aria-haspopup="true" aria-expanded="false">
          Edit Columns
        </button>

        <div className={this.state.showEditColumns ? 'dropdown-menu d-block' : 'd-none' } aria-labelledby="dropdownMenuButton">
        {
          Object.keys(this.state.columns).map( (value,key) =>(
            <a key={key} onClick={(e,column) => this.editColumns(e,value)} className="dropdown-item" href="#">
            { this.state.columns[value]
            ? <FiCheckSquare className="action-selected-icon" strokeWidth="1" />
            :  <FiSquare className="action-select-icon" strokeWidth="1" />
            }
            <span>{value.replace(/_/g, " ")}</span>
            </a>
          ) )
        }
        </div>
      </div>

      <div className="recordcount">
      {!this.props.isLoading &&
      <p><span>{this.props.paginate.total}</span>Records Found</p>
      }
      </div>

      <div className="dropdown download-button">
        <button className="btn dropdown-toggle" type="button"
        onClick={ this.toggleDownloadMenu }
        id="dropdownMenuButton"
        aria-haspopup="true" aria-expanded="false">
          Download
        </button>

        <div className={this.state.showDownloadMenu ? 'dropdown-menu dropdown-menu-right d-block' : 'd-none' } aria-labelledby="dropdownMenuButton">
        <a  onClick={(e) => this.downloadSelected(e)} className="dropdown-item" >
        <span>Download Selected</span>
        </a>
        <form id="downloadAll" method="post" action={APP_URL + '/export-all-contacts'} >
        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
        <input type="hidden" name="search" value={JSON.stringify(this.props.search)} />
        <button className="dropdown-item" >
        <span>Download All</span>
        </button>

        </form>

        </div>
      </div>

      </div>
      <AppTable leads={this.props.leads} allSelected={this.props.allSelected}
      toggleLead={this.props.toggleLead}
      selected={this.props.selected}
      selectAll={this.props.selectAll}
      isLoading={this.props.isLoading}
      setLoader={this.props.setLoader}
      columns={this.state.columns}
      />
      </div>
        <AppPagination isLoading={this.props.isLoading}
        goToPage={(pageNumber,perPage) => this.loadPaginateRecords(pageNumber,perPage)}
        paginate={this.props.paginate}
        perPage={this.props.search.perPage}
        handleValue={this.props.handleValue}
         />
      </div>
    }
    {
      this.props.leads.length === 0
      && this.props.hasStarted === true
      &&
      <div className="initialAppdiv">

          {
            this.props.isLoading &&
            <Loader/>
          }
          {
            ! this.props.isLoading &&
            <div>
            <h3>No Records Found</h3>
            <p>No Records found for your search paramaters.
            Please try again with different paramaters.</p>
            </div>
          }



        </div>
    }
    {
      this.props.hasStarted === 'sadasd' &&
      <div className="initialAppdiv">
        <h1>Welcome to Dollar Business Leads</h1>
        <p>Start your search from the left.</p>
        {
          this.props.isLoading &&
          <Loader/>
        }
      </div>
    }
    </div>
    );
  }

}

const mapStateToProps = state => {
  return {
    leads: state.leadsReducer.leads,
    selected:state.selectReducer.selectedLeads,
    allSelected:state.selectReducer.allLeadSelected,
    isLoading:state.leadsReducer.isLoading,
    paginate: state.leadsReducer.paginate,
    search: state.searchReducer,
    hasStarted:state.leadsReducer.hasStarted
  }
}

const mapDispactchToProps = (dispatch, ownProps ) => {
  return {
    getLeads: (leads,paginate) =>  dispatch(getLeads(leads,paginate)),
    selectAll: (lead_ids) => dispatch(selectAllLeads(lead_ids)),
    toggleLead: ( lead_id ) => dispatch(toggleLeadSelect(lead_id)),
    setLoader: (isLoading) =>  dispatch(setLoader(isLoading)),
    handleValue: (key,value) =>  dispatch(handleValue(key,value)),
    }
  }


export default connect( mapStateToProps, mapDispactchToProps )(AppDiv);
