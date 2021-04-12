/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */
 import React from 'react';
 import ReactDOM from 'react-dom';

require('./bootstrap');
require('./components/common/main.js');

import {Loader} from './components/Loader';

import PaymentForm from './components/payment/PaymentForm';

import {AppContainer} from './container/AppContainer';


if (document.getElementById('PaymentForm')) {
    ReactDOM.render(<PaymentForm/>, document.getElementById('PaymentForm'));
}

if (document.getElementById('appContainer')) {
    ReactDOM.render(<AppContainer/>, document.getElementById('appContainer'));
}
require('./modules/appglobal');


$('.alert-close-credit').on('click', function(){
    $(this).closest(".transaction-alert").remove();
});
