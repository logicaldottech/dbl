import React from 'react';
import Cards from 'react-credit-cards';
import axios from 'axios';
import swal from 'sweetalert';
import {APP_URL,XSRF,USERID} from '../../constants/site';
import {Loader} from '../Loader';
import {
  formatCreditCardNumber,
  formatCVC,
  formatExpirationDate,
  formatFormData,
} from './utils';

export default class PaymentForm extends React.Component {

  constructor(props){

    super(props);
    this.state = {
      cvc: '',
      expiry: '',
      focus: '',
      name: '',
      number: '',
      credits:'',
      cvcvalid:false,
      expiryvalid:false,
      namevalid:false,
      numbervalid:false,
      isloading:false
    };

    this.handleInputFocus = this.handleInputFocus.bind(this);
    this.handleInputChange = this.handleInputChange.bind(this);

    this.handleSubmit = this.handleSubmit.bind(this);

  }

  handleInputFocus(e) {
    this.setState({ focus: e.target.name });
  }

  handleInputChange(e){

    let target = e.target;
    if (target.name === 'number') {
      target.value = formatCreditCardNumber(target.value);
    } else if (target.name === 'expiry') {
      target.value = formatExpirationDate(target.value);
    } else if (target.name === 'cvc') {
      target.value = formatCVC(target.value);
    }

    this.setState({ [target.name]: target.value });

  }

  handleSubmit(e){
    e.preventDefault();
    console.log(this.calculate_cost());
    let data = this.state;

    let expirypattern = new RegExp(/^[0-9]{2}\/[0-9]{2}$/);

    let cvcpattern = new RegExp(/^[0-9]{3,4}$/);

    let namepattern = new RegExp(/^[a-zA-Z\s]{3,25}$/);

    let numberpattern = new RegExp(/^[0-9]{16,18}$/);


    let formdata = {};
    document.getElementById('PaymentFormallgroup').style.opacity = .4;
    this.setState({isLoading:true});
    axios({
      method:'post',
      url:APP_URL + '/pay',
      data:data
    }).then( res =>{
        console.log(res.data);
        document.getElementById('PaymentFormallgroup').style.opacity = 1;
        this.setState({isLoading:false});
        let code = parseInt(res.data.response);
        if( code === 1 ){
          console.log('good');
          swal({
            title: "Transaction Success",
            text: "Your transaction was successful",
            icon: "success"
          }).then((willRedirect) => {
            if(willRedirect){
              window.location.href = APP_URL + '/credits';
            }
          });

        } else {
          console.log('failed');
          swal({
            title: "Transaction Failed",
            text: res.data.responsetext,
            icon: "error"
          });
        }
      })
      .catch( error => {
        document.getElementById('PaymentFormallgroup').style.opacity = 1;
        this.setState({isLoading:false});
        console.log(error);
      });



    console.log(data);
  }


  calculate_cost(){
    let price_per_credit = parseFloat(document.getElementById('price_per_credit').innerText);
    let credits = parseInt(this.state.credits);
    let totalAmount = price_per_credit * credits;
    return totalAmount.toFixed(2);
  }

  render() {
    return (
      <div id="PaymentFormWrap">
        <Cards
          cvc={this.state.cvc}
          expiry={this.state.expiry}
          focused={this.state.focus}
          name={this.state.name}
          number={this.state.number}
        />

        <form className="PaymentForm" onSubmit={(e) => this.handleSubmit(e)}>
        <div id="PaymentFormallgroup">
        <div className="form-group">
           <label htmlFor="numberofcredits">Number Of Credits</label>
           <input
              onChange={(e) => this.handleInputChange(e)}
               onFocus={(e) => this.handleInputFocus(e)}
               name="credits"
               type="number" min="1" className="form-control" id="numberofcredits" aria-describedby="emailHelp" required />
           <small id="numberofcreditshelp" className="form-text text-muted">Number of credits you want to purchase.</small>

        </div>{/*--.form-group--*/}


         <div className="form-group">

          	<input
              type="tel"
              name="number"
              placeholder="Card Number"
              className="form-control"
              pattern="[\d| ]{16,22}"
              onChange={(e) => this.handleInputChange(e)}
              onFocus={(e) => this.handleInputFocus(e)}
              required
            />


            </div>{/*--.form-group--*/}

            <div className="form-group">

              <input
                type="text"
                name="name"
                className="form-control"
                placeholder="Your Name"
                onChange={(e) => this.handleInputChange(e)}
                onFocus={(e) => this.handleInputFocus(e)}
                required
              />
              </div>{/*--.form-group--*/}

              <div className="expirycvc form-group">

              <input
                type="tel"
                name="expiry"
                className="form-control"
                placeholder="Valid Thru"
                pattern="\d\d/\d\d"
                onChange={this.handleInputChange}
                onFocus={this.handleInputFocus}
                required
                  />

                  <input
                  type="tel"
                  name="cvc"
                  className="form-control"
                  placeholder="CVC"
                  pattern="\d{3,4}"
                  onChange={this.handleInputChange}
                  onFocus={this.handleInputFocus}
                  required
                />

                  </div>{/*--.form-group--*/}

              <div className="form-group">

              {
                this.state.credits !== '' &&
                <button className="btn btn-primary btn-block paybutton">PAY ${this.calculate_cost()}</button>
              }

              {
                this.state.credits === '' &&
                <button disabled className="btn btn-primary btn-block paybutton">PAY $0</button>
              }


              </div>{/*--.form-group--*/}


            </div>
            { this.state.isLoading && <Loader /> }
        </form>
      </div>
    );
  }
}
