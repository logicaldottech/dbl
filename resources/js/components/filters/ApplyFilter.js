import React from 'react';
import ReactDOM from 'react-dom';
import { FiCheck } from "react-icons/fi"
import {APP_URL} from '../../constants/site';
import axios from 'axios';
import swal from 'sweetalert';

export class ApplyFilter extends React.Component{

 constructor(props){
   super(props);
   this.search = this.search.bind(this);

 }

  search(){

    if ( this.props.valid === false ){
      swal('Invalid', this.props.error,'error');
      return;
    }

    console.log(this.props.search);
 //   this.props.setLoader(true);

    let query = this.props.search;
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
       // this.setState({ isLoading:true });

      });

  }
  render() {
    return (
      <div onClick={this.search} className="done-filter">
      <FiCheck className="" />
      <span>Apply Filter</span>
      </div>
    );
  }


}
