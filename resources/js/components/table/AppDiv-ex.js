import React from 'react';
import ReactDOM from 'react-dom';
import { FiSquare } from "react-icons/fi";
import {FiArrowUp} from "react-icons/fi";
import {FiArrowDown} from "react-icons/fi";
import {FiDownload} from "react-icons/fi";
import axios from 'axios';
import {AppTr} from './AppTr';
import {Loader} from './Loader';
import {AppPagination} from './AppPagination';
import {AppTable} from './AppTable';
import {store} from '../../store.js';
import {selectCheck,getLeads}  from '../../actions';



export class AppDiv extends React.Component{

  constructor(props){

    super(props);
    this.state = { isLoading:true, leads:['a'], paginate:'' };

    this.pageChange = this.pageChange.bind(this);


  }

  componentDidMount() {

      //   store.dispatch(getLeads(0));
        // console.log(store.getState());
         //var pageNumber = store.getState().pageNumber;


         axios.get('/app/public/api/leads')
         .then( res =>{
           console.log(res.data);
           store.dispatch(getLeads(res.data.leads));
           this.setState({ leads:res.data.leads, paginate:res.data.paginate, isLoading:false });
           //console.log(this.state);
           //   store.dispatch(getLeads(0));
           //console.log(store.getState());
         }).catch( error => {
           console.log(error);
           this.setState({ isLoading:true });

         });




  }

  loadPaginateRecords( pageNumber ){

    this.setState({ isLoading:true });

    axios.get('/app/public/api/leads', {
    params: {
      page: pageNumber + 1
    }
  })
  .then( res =>{
    console.log(res.data);
    this.setState({ leads:res.data.leads, paginate:res.data.paginate, isLoading:false });
    console.log(this.state);

  })
  .catch( error => {
    console.log(error);
    this.setState({ isLoading:true });

  });
  }

  pageChange(e){

   console.log(e.selected);
   this.loadPaginateRecords(e.selected);
 }

 getStorestate(){

   return store.getState();

 }

  render(){
    return(
      <div>
      <div className="app-main-table">
      <AppTable loading={ this.state.isLoading ? true : false } leads={this.getStorestate().leads}/>
      </div>
      <AppPagination onChange={(e) => this.pageChange(e)}/>
      </div>
    );
  }

}
