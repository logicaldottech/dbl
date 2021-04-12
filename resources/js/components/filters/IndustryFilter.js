import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi"
import { FaChevronRight } from "react-icons/fa";
import { FiChevronDown } from "react-icons/fi";
import {SubFilterLi} from './SubFilterLi';
import {CodesFilter} from './CodesFilter';
import {CodesFilter as LocationCodes} from './location/CodesFilter';
import axios from 'axios';
import {APP_URL} from '../../constants/site';
import {ApplyFilter} from './ApplyFilter';
import {IndustryCategory} from './industry/IndustryCategory';

export class IndustryFilter extends React.Component{

 constructor(props){
   super(props);

     this.state = { industries:[null], loading:true}
   this.search = this.search.bind(this);
 }

 search(){
   console.log(this.props.search);
//   this.props.setLoader(true);

   let query = this.props.search;
   this.props.setLoader(true);

   axios({
     method:'post',
     url:APP_URL + '/api/search',
     data:query
   }).then( res =>{
       console.log(res.data);
       this.props.getLeads(res.data.leads,res.data.paginate);

       this.props.setLoader(false);

     })
     .catch( error => {
       console.log(error);
      // this.setState({ isLoading:true });

     });

 }

 componentDidMount() {

  }


  render() {

    const TagsInput = props => {
    const [tags, setTags] = React.useState(props.tags);
    const removeTags = indexToRemove => {
        setTags([...tags.filter((_, index) => index !== indexToRemove)]);
    };
    const addTags = event => {
        if (event.target.value !== "") {
            setTags([...tags, event.target.value]);
            props.selectedTags([...tags, event.target.value]);
            event.target.value = "";
        }
    };
    return (
        <div className="tags-input">
            <ul id="tags">
                {tags.map((tag, index) => (
                    <li key={index} className="tag">
                        <span className='tag-title'>{tag}</span>
                        <span className='tag-close-icon'
                            onClick={() => removeTags(index)}
                        >
                            x
                        </span>
                    </li>
                ))}
            </ul>
            <input
                type="text"
                onKeyUp={event => event.key === "Enter" ? addTags(event) : null}
                placeholder={'Press Enter To Add ' + this.props.code} name ={ this.props.name}
            />
            <hr className="line"/>
        </div>
    );
};

const App = () => {
      const selectedTags = tags => {
          console.log(tags);
      };
      return (
          <div className="App">
              <TagsInput selectedTags={selectedTags}  tags={[]}/>
          </div>
      );
  };

    return (
<div>
        <ul>

        <SubFilterLi subfilter="NAICS Code">
        <CodesFilter
        multiEditSearch={this.props.multiEditSearch}
        multiAddSearch={this.props.multiAddSearch}
        multiRemoveSearch={this.props.multiRemoveSearch}
        clearAll={this.props.clearAll}
        code="NAICS" name="naics"

        />
        </SubFilterLi>

        <SubFilterLi subfilter="PSC Code">
        <CodesFilter
        multiEditSearch={this.props.multiEditSearch}
        multiAddSearch={this.props.multiAddSearch}
        multiRemoveSearch={this.props.multiRemoveSearch}
        code="PSC" name="psc"/>

        </SubFilterLi>

        </ul>
        <ApplyFilter
          search={this.props.search}
          leads={this.props.leads}
          getLeads={this.props.getLeads}
          setLoader={this.props.setLoader}
         />
        </div>

    );
  }


}
