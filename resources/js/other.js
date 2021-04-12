/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */
 import React from 'react';
 import ReactDOM from 'react-dom';

require('./bootstrap');

require('./components/common/main.js');


 import {ProfileCard} from './components/profile/ProfileCard';


if (document.getElementById('profile-card-view')) {
    ReactDOM.render(<ProfileCard/>, document.getElementById('profile-card-view'));
}


$('.alert-close-credit').on('click', function(){
    $(this).closest(".transaction-alert").remove();
});
