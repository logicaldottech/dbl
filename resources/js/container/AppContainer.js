import React from 'react';
import ReactDOM from 'react-dom';
import AppSearchView from './AppSearchView';
import AppSidebar from './AppSidebar';
import AppDiv from '../components/table/AppDiv';
import { Provider } from 'react-redux';
import {store} from '../store.js';
import {selectCheck,getLeads}  from '../actions';
import swal from 'sweetalert';
import {APP_URL} from '../constants/site';
import axios from 'axios';
import {FiSave} from "react-icons/fi";
import {FaHome,FaIndustry} from "react-icons/fa";
import { AiOutlineFileSearch } from "react-icons/ai";
import IndustrySearch from '../components/industrysearch/IndustrySearch';
import {
  BrowserRouter as Router,
  Switch,
  Route,
  NavLink,
  Link
} from "react-router-dom";

export class AppContainer extends React.Component{
 constructor(props){
   super(props);

   this.state = {
     loader:false,
     searchView:false,
     searchShow:false,
     searchData:[],
    };
    this.saveSearch=this.saveSearch.bind(this);

 }

 saveSearch(e){
   console.log("enter saved search");
   let searchedObj = store.getState().searchReducer;

   console.log(searchedObj);
   swal({
      text: 'Search Name',
      content: "input",
      buttons: {
        cancel: "CANCEL",
        save: {
          text: "SAVE",
          value: "save",
          closeModal: false,
        },
      },
    })
    .then( (name) => {

      let getstate = swal.getState();
      let value = getstate.actions.confirm.value;
      console.log(value);
      switch (name) {

          case "save":
          if (value == "") {
            swal({
              title: "Error",
              text: 'Search Name Field Is Required',
              icon: "error",
            });
          }
          else {
            axios({
              method:'post',
              url:APP_URL + '/save-search',
              data:{search_name:value, search:searchedObj}
            }).then( res =>{
                console.log(res.data);

                if (res.data === true) {

                  swal({
                    title: "Success",
                    text: "Search Saved Successfully",
                    icon: "success",
                  });

                }
              })
              .catch( error => {
                console.log(error);
              }); //end axios
          } // end else

            break;

          default:
            swal.close();
        }
    })
    .catch(err => {
      if (err) {
        //swal("Oh noes!", "The AJAX request failed!", "error");
      } else {
        swal.stopLoading();
        swal.close();
      }
    });
 }


  render() {
    return (
      <Router>
      <Provider store={store}>

      <div className="app-container ">

      <div className="">
      <nav className="appbar navbar navbar-expand-lg navbar-light bg-light">
      <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span className="navbar-toggler-icon"></span>
      </button>

      <div className="collapse navbar-collapse" id="navbarSupportedContent">
  <ul className="navbar-nav mr-auto">
    <li className="nav-item">
      <NavLink activeClassName="active" className="nav-link" exact to="/"><FaHome/><span>Home</span><span className="sr-only">(current)</span></NavLink>
    </li>
    <li className="nav-item">
      <Link  onClick={(e)=>this.saveSearch(e)} className="nav-link" to="tosave"><FiSave/><span>Save Search</span></Link>
    </li>
    <li className="nav-item">
      <NavLink activeClassName="active" className="nav-link" exact to="/saved"><AiOutlineFileSearch/><span>My Saved Searches</span></NavLink>
    </li>
    <li className="d-none nav-item">
      <NavLink activeClassName="active" className="nav-link" exact to="/industrysearch"><FaIndustry/><span>Industry Search</span></NavLink>
    </li>
  </ul>
  <div className="d-none my-2 my-lg-0">
    <p>Credits </p>
  </div>
</div>
      </nav>


      </div>

      <Switch>
      <Route path="/saved">
        <AppSearchView />
      </Route>
      <Route path="/industrysearch">
        <IndustrySearch />
      </Route>

          <Route path="/">
          <div className="row main-site-row">
          <div className="col-3">
          <AppSidebar/>
          </div>
          <div className="col-9">
          <AppDiv/>
          </div>
        </div>
                </Route>


    </Switch>

      </div>{/*---.app-container--*/}


          </Provider>
</Router>


    );
  }


}

function Home() {
  return <h2>Home</h2>;
}

function About() {
  return <h2>About</h2>;
}

function Users() {
  return <h2>Users</h2>;
}
