import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import {ApplyFilter} from './../ApplyFilter';
import axios from 'axios';
import {APP_URL} from '../../../constants/site';
import {FiSquare,FiCheckSquare} from "react-icons/fi";

export class IndustryCategory extends React.Component{


  constructor(props){
    super(props);

    this.state = {
      isLoading:true,
      sectors:{},
      category:[]
    }

    this.selectIndustry = this.selectIndustry.bind(this);
  }

selectIndustry( value ){
  let firstValue = value[0];
  let oldState = this.props.search.industry_category;
  let newState = oldState.indexOf(firstValue) < 0 ?
  [...oldState,...value] :
  oldState.filter( (el) => value.indexOf(el) < 0 );

  this.props.handleValue('industry_category',newState);


}

  render() {

  return (
    <div className="IndustryCategory">
    <ul>


      <li onClick={(e) => this.selectIndustry([11]) }>
      { this.props.search.industry_category.indexOf(11) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Agriculture</li>

      <li onClick={(e) => this.selectIndustry([21]) }>
      { this.props.search.industry_category.indexOf(21) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Mining</li>

      <li onClick={(e) => this.selectIndustry([22]) }>
      { this.props.search.industry_category.indexOf(22) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Utilities</li>

      <li onClick={(e) => this.selectIndustry([23]) }>
      { this.props.search.industry_category.indexOf(23) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Construction</li>

      <li onClick={(e) => this.selectIndustry([31,32,33]) }>
      { this.props.search.industry_category.indexOf(31) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Manufacturing</li>

      <li onClick={(e) => this.selectIndustry([42]) }>
      { this.props.search.industry_category.indexOf(42) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Wholesale Trade</li>


      <li onClick={(e) => this.selectIndustry([44,45]) }>
      { this.props.search.industry_category.indexOf(44) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Retail Trade</li>

      <li onClick={(e) => this.selectIndustry([48,49]) }>
      { this.props.search.industry_category.indexOf(48) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Transportation and Warehousing</li>

      <li onClick={(e) => this.selectIndustry([51]) }>
      { this.props.search.industry_category.indexOf(51) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Information</li>

      <li onClick={(e) => this.selectIndustry([52]) }>
      { this.props.search.industry_category.indexOf(52) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Finance and Insurance</li>

      <li onClick={(e) => this.selectIndustry([53]) }>
      { this.props.search.industry_category.indexOf(53) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Real Estate and Rental</li>

      <li onClick={(e) => this.selectIndustry([54]) }>
      { this.props.search.industry_category.indexOf(54) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Professional and Technical Services</li>

      <li onClick={(e) => this.selectIndustry([55]) }>
      { this.props.search.industry_category.indexOf(55) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Management of Companies and Enterprises</li>

      <li onClick={(e) => this.selectIndustry([56]) }>
      { this.props.search.industry_category.indexOf(56) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Administrative and Support Management</li>

      <li onClick={(e) => this.selectIndustry([61]) }>
      { this.props.search.industry_category.indexOf(61) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Educational Services</li>

      <li onClick={(e) => this.selectIndustry([62]) }>
      { this.props.search.industry_category.indexOf(62) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Health Care and Social Assistance</li>

      <li onClick={(e) => this.selectIndustry([71]) }>
      { this.props.search.industry_category.indexOf(71) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Arts, Entertainment, and Recreation</li>

      <li onClick={(e) => this.selectIndustry([72]) }>
      { this.props.search.industry_category.indexOf(72) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Accommodation and Food Services</li>

      <li onClick={(e) => this.selectIndustry([81]) }>
      { this.props.search.industry_category.indexOf(81) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Other Services</li>

      <li onClick={(e) => this.selectIndustry([92]) }>
      { this.props.search.industry_category.indexOf(92) === -1
        ?       <FiSquare/>
        :<FiCheckSquare/>
      } Public Administration</li>

    </ul>
    <ApplyFilter
      search={this.props.search}
      setLoader={this.props.setLoader}
     />
    </div>
  );

  }


}
