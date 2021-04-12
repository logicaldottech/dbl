import React from 'react';
import ReactDOM from 'react-dom';
import {APP_URL} from '../../constants/site';
import { FiChevronDown } from "react-icons/fi";

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
