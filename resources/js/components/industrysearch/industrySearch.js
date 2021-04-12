import React from 'react';
import ReactDOM from 'react-dom';
import { FiCircle } from "react-icons/fi";
import { FiCheck } from "react-icons/fi";
import {selectCheck,getLeads,selectAllLeads,toggleLeadSelect,setLoader}  from '../../actions';
import { connect } from 'react-redux';


class IndustrySearch extends React.Component{

 constructor(props){
   super(props);

   this.state = {
     sectorsCode: [],
     sectorsTitle: [],
     subsectors: [],
     subSectorsCode: [],
     subSectorsTitle: [],

   }

   this.handleChange = this.handleChange.bind(this);
   this.handleChangeSubSector = this.handleChangeSubSector.bind(this);
 }

handleChangeSubSector(e){

  console.log(e.target.value);
  console.log(e.target.checked);

  let checked = e.target.checked;
  let value = e.target.value;
  let iSubSectortitleAr = this.props.industries.filter(sector => sector.code == value);
  let iSubSectortitle = iSubSectortitleAr[0].title;
  if (checked == true) {

      let SubsectorCodeArr = this.state.subSectorsCode.concat(value);
      let SubsectorTitleArr = this.state.subSectorsTitle.concat(iSubSectortitle);

      this.setState({subSectorsCode:SubsectorCodeArr, subSectorsTitle:SubsectorTitleArr}, () => {
        console.log(this.state);
      });

    }//end if

    else {

      let subSectorCodeArr = [...this.state.subSectorsCode]; // make a separate copy of the array
      let subSsectorTitleArr = [...this.state.subSectorsTitle]; // make a separate copy of the array

      let index = subSectorCodeArr.indexOf(value);
      if (index !== -1) {
        subSectorCodeArr.splice(index, 1);
      }

      let indexTitle = subSsectorTitleArr.indexOf(iSubSectortitleAr);
      if (indexTitle !== -1) {
        subSsectorTitleArr.splice(indexTitle, 1);
      }

      this.setState({
            subSectorsCode:subSectorCodeArr,
            subSectorsTitle:subSsectorTitleArr,
          }, () => {
        console.log(this.state);
      });

    } //end else
}

handleChange(e){

  console.log(e.target.value);
  console.log(e.target.checked);

  let checked = e.target.checked;
  let value = e.target.value;
  let iSectortitleAr = this.props.industries.filter(sector => sector.code == value);
  let iSectortitle = iSectortitleAr[0].title;

  // sub sectors
  let regex = new RegExp("^(" + value + ")([0-9]{1})", "g");

  if (checked == true) {

      let sectorCodeArr = this.state.sectorsCode.concat(value);
      let sectorTitleArr = this.state.sectorsTitle.concat(iSectortitle);

      this.setState({sectorsCode:sectorCodeArr, sectorsTitle:sectorTitleArr}, () => {
        console.log(this.state);
      });


  let iSubSectortitleAr = this.props.industries.filter(sector => sector.code.toString().match(regex)
                           && sector.level == "Subsectors");

  let newssector = this.state.subsectors.concat(iSubSectortitleAr);

  this.setState({subsectors:newssector});
  console.log(iSubSectortitleAr);

  }else {

    let sectorCodeArr = [...this.state.sectorsCode]; // make a separate copy of the array
    let sectorTitleArr = [...this.state.sectorsTitle]; // make a separate copy of the array

    let index = sectorCodeArr.indexOf(value);

    if (index !== -1) {
      sectorCodeArr.splice(index, 1);
    }

    let indexTitle = sectorTitleArr.indexOf(iSectortitle);
    if (indexTitle !== -1) {
      sectorTitleArr.splice(indexTitle, 1);
    }

    let subSectorCodeArr = this.state.subsectors.filter(sector => !sector.code.toString().match(regex));


    let iSubSectorCodeAr = this.state.subSectorsCode.filter(sector => !sector.toString().match(regex));


    console.log(iSubSectorCodeAr);
    this.setState({
          sectorsCode:sectorCodeArr,
          sectorsTitle:sectorTitleArr,
          subSectorsCode:iSubSectorCodeAr,
          // subSectorsTitle:iSubSectortitleAr,
          subsectors:subSectorCodeArr,
        }, () => {
      console.log(this.state);
    });

  }

}

  render() {

    const industriesSector = this.props.industries.filter(sector => sector.level == "Sectors");

    const isector = industriesSector.map((i) =>
                <li key={i.id}>
                  <input type="checkbox" onChange={(e) => this.handleChange(e)} value={i.code} />{i.title}
                </li>
              );
    return (
      <div id="industry-search-filter-deep">

      {
        this.props.industries.length === 0 ?
        <p>Loading</p>
        :

        <div className="industry-filter-sectors">
          {isector}
        </div>


      }

      { this.state.subsectors.length > 0 &&

        this.state.subsectors.map((i) =>
                    <li key={i.id}>
                      <input type="checkbox" onChange={(e) => this.handleChangeSubSector(e)} value={i.code} />{i.title}
                    </li>
                  )

      }
      </div>
    );
  }


}


const mapStateToProps = state => {
  return {
    industries:state.leadsReducer.industries,
    hasStarted:state.leadsReducer.hasStarted
  }
}

const mapDispactchToProps = (dispatch, ownProps ) => {
  return {
    getLeads: (leads,paginate) =>  dispatch(getLeads(leads,paginate)),
    selectAll: (lead_ids) => dispatch(selectAllLeads(lead_ids)),
    toggleLead: ( lead_id ) => dispatch(toggleLeadSelect(lead_id)),
    setLoader: (isLoading) =>  dispatch(setLoader(isLoading)),

    }
  }


export default connect( mapStateToProps, mapDispactchToProps )(IndustrySearch);
