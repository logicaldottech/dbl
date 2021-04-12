import React from 'react';
import ReactDOM from 'react-dom';
import swal from 'sweetalert';
import {APP_URL} from '../constants/site';
import axios from 'axios';
import { connect } from 'react-redux';


class AppSavedSearch extends React.Component{
 constructor(props){
   super(props);

   this.state = {

      loader:"false",

    };
   this.saveSearch=this.saveSearch.bind(this);
 }

 saveSearch(){
   console.log("enter saved search");

   swal({
      text: 'Search Name',
      content: "input",
      buttons: {
        cancel: "CANCEL",
        save: {
          text: "SAVE search",
          value: "save",
          closeModal: false,
        },
      },
    })
    .then(name => {
      if (!name) {
        swal({
          title: "Error",
          text: 'Search Name Field Is Required',
          icon: "error",
        });
      }

      switch (value) {

          case "save":
          axios({
            method:'post',
            url:APP_URL + '/save-search',
            data:{search_name:name}
          }).then( res =>{
              console.log(res.data);

              if (res.data === true) {

                swal({
                  title: "Success",
                  text: "Search Saved Successfully",
                  icon: "success",
                });

              }else if (res.data == "name_exists") {

                swal({
                  title: "Error",
                  text: "Search Name Already Exists",
                  icon: "error",
                });

              }

            })
            .catch( error => {
              console.log(error);
            });

            break;

          default:
            swal.close();
        }

    })
    .catch(err => {
      if (err) {
        swal("Oh noes!", "The AJAX request failed!", "error");
      } else {
        swal.stopLoading();
        swal.close();
      }
    });
 }


// geek code End

  render() {

    return (
      <div className="save-search">
        <button className="btn" onClick={(e)=>this.saveSearch(e)}  type="button">SAVE SEARCH</button>


        <button onClick={this.props.action} className="btn" type="button">MY SAVED SEARCHES</button>
        <button className="btn" type="button">CLEAR ALL CRITERIA</button>
      </div>
    );
  }


}
export default AppSavedSearch;


const mapStateToProps = state => {
  return {
    searchReducer: state.searchReducer
  }
}

export default connect( mapStateToProps )(AppSavedSearch);
