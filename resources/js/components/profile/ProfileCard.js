import React from 'react';
import ReactDOM from 'react-dom';
import swal from 'sweetalert';
import {APP_URL} from '../../constants/site';
import axios from 'axios';
import { FaRegEdit } from "react-icons/fa";
import { FaCheckCircle } from "react-icons/fa";

 export class ProfileCard extends React.Component{

   constructor(props){
     super(props);

     this.state = {
       loader:false,
       user:[],
       userInfoEdit:false,
       userPasswordEdit:false,
       first_name:"",
       last_name:"",
       email:"",
       phone:"",
       password:"",
       cpassword:"",
      };

      this.handleChangeFname = this.handleChangeFname.bind(this);
      this.handleChangeLname = this.handleChangeLname.bind(this);
      this.handleChangeEmail = this.handleChangeEmail.bind(this);
      this.handleChangePhone = this.handleChangePhone.bind(this);
      this.handleSubmit = this.handleSubmit.bind(this);
      this.handleSubmitPassword = this.handleSubmitPassword.bind(this);
      this.cancelEdit = this.cancelEdit.bind(this);
      this.cancelEditPass = this.cancelEditPass.bind(this);
   }

   handleChangePhone(e){
     e.preventDefault();
     console.log(e.target.value);

     if (e.target.value == "") {

       this.setState({ phone: "" });

     }else{

       this.setState({ phone: e.target.value });

     }
     console.log(this.state);
   }

   handleChangeFname(e){
     e.preventDefault();
     console.log(e.target.value);

     if (e.target.value == "") {

       this.setState({ first_name: "" });

     }else{

       this.setState({ first_name: e.target.value });

     }
     console.log(this.state);
   }

   handleChangeLname(e){
     e.preventDefault();
     console.log(e.target.value);

     if (e.target.value == "") {

        this.setState({ last_name: "" });

     }else{

       this.setState({ last_name: e.target.value });

     }
     console.log(this.state);

   }

   handleChangeEmail(e){
     e.preventDefault();
     console.log(e.target.value);

     if (e.target.value == "") {

        this.setState({ email: "" });

     }else{

       this.setState({ email: e.target.value });

     }
     console.log(this.state);

   }

   handleChangePassword(e){
     e.preventDefault();
     console.log(e.target.value);

     if (e.target.value == "") {

        this.setState({ password: "" });

     }else{

       this.setState({ password: e.target.value });

     }
     console.log(this.state);

   }

   handleChangeCpassword(e){
     e.preventDefault();
     console.log(e.target.value);

     if (e.target.value == "") {

        this.setState({ cpassword: "" });

     }else{

       this.setState({ cpassword: e.target.value });

     }
     console.log(this.state);

   }

   handleSubmitPassword(e){
     e.preventDefault();
     console.log(this.state);
     let password = this.state.password;
     let cpassword = this.state.cpassword;

     if (password == "") {

       swal({
         title: "Error",
         text: "Password field is required",
         icon: "error",
         button: "Ok",
       });

     }
     else if (cpassword == "") {

       swal({
         title: "Error",
         text: "Confirm Password field is required",
         icon: "error",
         button: "Ok",
       });

     }
     else if (password !== cpassword) {

       swal({
         title: "Error",
         text: "Password And Confirm Password Not Match",
         icon: "error",
         button: "Ok",
       });

     }else if(password.length < 6){

       swal({
         title: "Error",
         text: "Password Must Have 6 Digit",
         icon: "error",
         button: "Ok",
       });

     }else{

       console.log("submit");

       this.setState({loader:true});
       axios({
         method:'post',
         url:APP_URL + '/update-user-password',
         data:{password: password}
       }).then( res =>{
           console.log(res.data);

           if (res.data === true) {

             this.setState({ userPasswordEdit: false, userInfoEdit:false, loader:false, password:"", cpassword:"" })
             swal({
               title: "Success",
               text: "Password Update Succesfully",
               icon: "success",
               button: "Ok",
             });

           }
         })
         .catch( error => {
           console.log(error);
         });

     }

   }

   handleSubmit(e){
     e.preventDefault();
     console.log(this.state);

     let fname = this.state.first_name;
     let lname = this.state.last_name;
     let email = this.state.email;
     let phone = this.state.phone;
     let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

     if (fname == "") {

       swal({
         title: "Error",
         text: "First name field is required",
         icon: "error",
         button: "Ok",
       });

     }else if (lname == "") {

       swal({
         title: "Error",
         text: "Last name field is required",
         icon: "error",
         button: "Ok",
       });

     }else if (email == "") {

       swal({
         title: "Error",
         text: "Email field is required",
         icon: "error",
         button: "Ok",
       });

     }else if (!email.match(regex)) {

       swal({
         title: "Error",
         text: "Enter valid email address",
         icon: "error",
         button: "Ok",
       });

     }else if (phone.length > 0 && phone.length !== 10) {

       swal({
         title: "Error",
         text: "Phone number must be 10 digits",
         icon: "error",
         button: "Ok",
       });

     }else{
       console.log("submit");

       this.setState({loader:true});
       axios({
         method:'post',
         url:APP_URL + '/update-user-data',
         data:{first_name: fname, last_name:lname, email:email, phone:phone}
       }).then( res =>{
           console.log(res.data);

           if (res.data == "email_exists") {
             swal({
               title: "Error",
               text: "Email Already Exists",
               icon: "error",
               button: "Ok",
             });
           }else{

             let fname = res.data[0].first_name;
             let lname = res.data[0].last_name;
             let email = res.data[0].email;
             let phone = res.data[0].phone;

             if (phone == null) {
               phone = "";
             }

             this.setState({ user:res.data, userInfoEdit:false, userPasswordEdit:false, loader:false, first_name: fname, last_name:lname, email:email, phone:phone })

             console.log(this.state);

             // swal for success
             swal({
               title: "Success",
               text: "Info Update Succesfully",
               icon: "success",
               button: "Ok",
             });

           }
           //end else
         })
         .catch( error => {
           console.log(error);
         });

     }

   }

   editUserInfo(e){
     e.preventDefault();

     this.setState({userInfoEdit:true});
   }

   editPassword(e){
     e.preventDefault();

     this.setState({userPasswordEdit:true});
   }

   cancelEdit(e){
     e.preventDefault();

     this.setState({userInfoEdit:false});
   }

   cancelEditPass(e){
     e.preventDefault();

     this.setState({userPasswordEdit:false});
   }

   componentDidMount(){

     this.setState({loader:true});
     axios({
       method:'post',
       url:APP_URL + '/get-user-data',
       data:{}
     }).then( res =>{
         console.log(res.data);

         let fname = res.data[0].first_name;
         let lname = res.data[0].last_name;
         let email = res.data[0].email;
         let phone = res.data[0].phone;

         if (phone == null) {
           phone = "";
         }

         this.setState({ user:res.data, loader:false, first_name: fname, last_name:lname, email:email, phone:phone })

         console.log(this.state);
       })
       .catch( error => {
         console.log(error);
       });

   }

   render(){
     return(

       <div className="container">
        <div className="row">
          <div className="col-sm-2"></div>
          <div className="col-sm-8">
            <div className="card">
              <div className="card-header">
                <div className="card-heading">Account Info</div>
                <div onClick={(e) => this.editUserInfo(e)} className="edit-icon-profile"><FaRegEdit /></div>
              </div>

              {
                !this.state.loader && !this.state.userInfoEdit &&

                this.state.user.map( (value) =>
                  <div key={value.id} className="card-body userinfocard">
                    <div className="d-flex">
                      <div className="p-2">First Name</div>
                      <div className="p-2">{value.first_name}</div>
                    </div>

                    <div className="d-flex">
                      <div className="p-2">Last Name</div>
                      <div className="p-2">{value.last_name}</div>
                    </div>

                    <div className="d-flex">
                      <div className="p-2">Email Address</div>
                      <div className="p-2">{value.email}</div>
                    </div>

                    <div className="d-flex">
                      <div className="p-2">Phone Number</div>
                      {
                        this.state.phone == "" &&
                        <div className="p-2">Phone Number Not Found</div>
                      }
                      {
                        this.state.phone !== "" &&
                        <div className="p-2">{value.phone}</div>
                      }
                    </div>

                    <div className="d-flex">
                      <div className="p-2">Credits Balance</div>
                      <div className="p-2">{value.credit.balance}</div>
                    </div>
                  </div>
                )
              }

              {
                this.state.userInfoEdit &&

                this.state.user.map( (value) =>
                  <div key={value.id} className="card-body">
                    <div className="form-group">
                      <label htmlFor="firstname">First Name</label>

                        <input type="text"
                          className="form-control"
                          value={this.state.first_name}
                          onChange={(e) => this.handleChangeFname(e)}
                          />

                    </div>

                    <div className="form-group">
                      <label htmlFor="lastname">Last Name</label>

                        <input type="text"
                          className="form-control"
                          value={this.state.last_name}
                          onChange={(e) => this.handleChangeLname(e)}
                          />

                    </div>

                    <div className="form-group">
                      <label htmlFor="email">Email Address</label>

                        <input type="text"
                          className="form-control"
                          value={this.state.email}
                          onChange={(e) => this.handleChangeEmail(e)}
                          />

                    </div>

                    <div className="form-group">
                      <label htmlFor="phone">Phone Number</label>

                        <input type="number"
                          className="form-control"
                          value={this.state.phone}
                          onChange={(e) => this.handleChangePhone(e)}
                          />

                    </div>
                    <div className="float-right">
                      <span className="cancel-profile-edit" onClick={(e) => this.cancelEdit(e)}>Cancel</span>
                      <button onClick={(e) => this.handleSubmit(e)} type="button" className="btn btn-success">Update</button>
                    </div>
                  </div>
                )
              }
            </div>
          </div>
        </div>

       <div className="row">
         <div className="col-sm-2"></div>
         <div className="col-sm-8">
           <div className="card card-password">
             <div className="card-header">
               <div className="card-heading">Password</div>
               <div onClick={(e) => this.editPassword(e)} className="edit-icon-profile"><FaRegEdit /></div>
             </div>
          { !this.state.userPasswordEdit &&
         <div className="card-body">
           <div className="align-items-center d-flex">
             <div className="p-2 check-right-icon"><FaCheckCircle/></div>
             <div className="p-2"><h3>Password has been set</h3></div>
           </div>

           <div className="align-items-center d-flex">
             <div className="p-2"></div>
             <div className="p-2">Choose a strong unique password thats at least 6 character long.</div>
           </div>

         </div>
       }
             {
               this.state.userPasswordEdit &&

                 <div className="card-body">
                   <div className="form-group">
                     <label htmlFor="password">New Password</label>

                       <input type="password"
                         className="form-control"
                         value={this.state.password}
                         onChange={(e) => this.handleChangePassword(e)}
                         />

                   </div>

                   <div className="form-group">
                     <label htmlFor="lastname">Confirm Password</label>

                       <input type="password"
                         className="form-control"
                         value={this.state.cpassword}
                         onChange={(e) => this.handleChangeCpassword(e)}
                         />

                   </div>
                   <div className="float-right">
                     <span className="cancel-profile-edit" onClick={(e) => this.cancelEditPass(e)}>Cancel</span>
                     <button onClick={(e) => this.handleSubmitPassword(e)} type="button" className="btn btn-success">Update</button>
                   </div>
                 </div>
             }
           </div>
         </div>
       </div>
       </div>
     );
   }
 }
