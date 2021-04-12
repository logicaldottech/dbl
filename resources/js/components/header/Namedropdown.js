import React from 'react';
import ReactDOM from 'react-dom';
import {APP_URL} from '../../constants/site';
import { FiChevronDown } from "react-icons/fi";

function NameDropdown() {
    return (
      <div className="dropdown nameDropdown">
      <a className="" href="#" >
       <span>Vivek</span><i className="fa fa-angle-down"></i>
      </a>
      <ul className="dropdowns dropdown-menu dropdown-menu-right">
      <a className="dropdown-item" href="#">{APP_URL}Profile</a>
      <a className="dropdown-item" href="#">Credits</a>
      <a className="dropdown-item" href="/public/app/logout">Logout</a>
      </ul>
      </div>
    );
}

//export default NameDropdown;

function UserMenuDropdownIcon() {
    return (
      <i>
      <FiChevronDown />
      </i>
    );
}


if (document.getElementById('UserMenu')) {
   ReactDOM.render(<UserMenuDropdownIcon />, document.getElementById('UserMenu'));
}
