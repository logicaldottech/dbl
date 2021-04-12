import React from 'react';
import ReactDOM from 'react-dom';
import swal from 'sweetalert';
import {APP_URL} from '../constants/site';
import axios from 'axios';
import { FaEye } from "react-icons/fa";
import { FaTrashAlt } from "react-icons/fa";


class AppSearchView extends React.Component{
 constructor(props){
   super(props);
   this.state = {

      loader: false,
      searchData:[]

    };
    this.viewSearchResults = this.viewSearchResults.bind(this);

 }

 viewSearchResults(e, id){
   e.preventDefault();
   console.log("view search result");
   console.log(id);
    this.setState({ loader: false });

    axios({
      method:'post',
      url:APP_URL + '/get-search-single',
      data:{id:id}
    }).then( res =>{
        console.log(res.data);

        if (res.data) {

          swal({
            text: res.data,
            buttons: {
            cancel: "Close",
            search: "View Results",
            }
          })
          .then( value =>{

            if (value) {
              console.log("write method foe view search results");
            }else {
              swal.close();
            }
          });

        }
        this.setState({ loader: false });

      })
      .catch( error => {
        console.log(error);
      }); //end axios

 }

 componentDidMount(){

   this.setState({ loader:true });
   axios({
     method:'post',
     url:APP_URL + '/saved-search-list',
     data:{}
   }).then( res =>{
       console.log(res.data);

       if (res.data.length > 0) {

         this.setState({ searchData:res.data })

       }
       this.setState({loader:false});
     })
     .catch( error => {
       console.log(error);
     });
 }

deleteSearch(id){
  console.log("enter delete search");
  console.log(id);
// swal confirm delete
  swal({
      title: "Are you sure?",
      text: "Press OK, If You Want To Delete This Search",
      icon: "warning",
      dangerMode: true,
      buttons: true,
    })
    .then((value) => {
      if (value) {

        axios({
          method:'post',
          url:APP_URL + '/delete-saved-search',
          data:{search_id:id}
        }).then( res =>{
            console.log(res.data);
            if (res.data === true) {

              swal({
                title: "Success",
                text: 'Search Deleted Successfully!',
                icon: "success",
              }).then( (value) => {

                this.setState({ loader:true });

                axios({
                  method:'post',
                  url:APP_URL + '/saved-search-list',
                  data:{}
                }).then( res =>{
                    console.log(res.data);

                    if (res.data.length > 0) {

                      this.setState({ searchData:res.data })

                    }else{

                      this.setState({ searchData:[] })

                    }
                    this.setState({loader:false});
                  })
                  .catch( error => {
                    console.log(error);
                  });
                // end inner axios
              });

            }else{

              swal({
                title: "Error",
                text: 'Some Error Occured, Please Try Again',
                icon: "error",
              });

            }
            this.setState({loader:false});
            console.log(this.state);
          })
          .catch( error => {
            console.log(error);
          });

      } //end if
       else {
        swal.close();
      } // end else
    }); //end then

}
// geek code End

  render() {

    return (
        <div id="saved-search-view" className="container">
          <div className="row">
          <div className="col-sm-1"></div>
            <div className="col-sm-10">
            {
              this.state.loader &&
              <div id="spin-area-search">
               <svg id="logoicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 386.32 410.11"><title>animsingle</title><path id="blackpart" className="cls-1" d="M640.6,564.81V195c-66.26-8.3-128.15-21.15-162.54-21.15v156L583.19,435l21.06,21.07V584C613.29,575.87,626.29,569.83,640.6,564.81Z" transform="translate(-478.06 -173.89)"/><path id="orangepart" className="cls-2" d="M663.85,197.26V558.81c36.63-10.64,74.35-18,74.35-37.9V456.06L864.39,329.87v-156C816.52,205.8,738.82,205.42,663.85,197.26Z" transform="translate(-478.06 -173.89)"/></svg>
             </div>
            }

            {
              !this.state.loader &&

              <table className="table table-light table-hover table-striped table-bordered text-center">
                <thead className="search-table-view-head">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" colSpan="3">Name</th>
                    <th scope="col" colSpan="3">Date</th>
                    <th scope="col" colSpan="3">Actions</th>
                  </tr>
                </thead>
                <tbody>
                {
                  this.state.searchData.length === 0 &&
                  <tr>
                    <th scope="row" colSpan="8">No Saved Searches Found</th>
                  </tr>
                }

                {
                  this.state.searchData.length > 0 &&

                  this.state.searchData.map((value, index)=>
                    <tr className="table-sm" key={index}>
                      <th scope="row">{index+1}</th>
                      <td colSpan="3"> {value.name} </td>
                      <td colSpan="3"> {value.created_at} </td>
                      <td colSpan="3">
                        <div className="d-flex flex-row">
                          <div className="p-2"><a onClick={(e) => this.viewSearchResults(e, value.id)} href=""> <FaEye /> </a></div>
                          <div onClick={this.deleteSearch.bind(this, value.id)} className="p-2 delete-search-one"><FaTrashAlt /></div>
                        </div>
                      </td>
                    </tr>
                  )
                }
                </tbody>
              </table>
            }
            </div>
          </div>
        </div>
    );
  }


}
export default AppSearchView;
