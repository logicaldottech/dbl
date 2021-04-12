import React from 'react';
import ReactDOM from 'react-dom';
import swal from 'sweetalert';

export class CodesFilter extends React.Component{
constructor(props){

   super(props);
 }


  render() {

  	const TagsInput = props => {
    const [tags, setTags] = React.useState(props.tags);
    const removeTags = indexToRemove => {
        setTags([...tags.filter((_, index) => index !== indexToRemove)]);
    };
    const addTags = event => {
      if (this.props.code == 'Zip') {

        if (event.target.value !== "") {

          var numbers = /^[0-9]+$/;
          if(event.target.value.match(numbers) && event.target.value.toString().length === 5)
          {
            setTags([...tags, event.target.value]);
            props.selectedTags([...tags, event.target.value]);
            event.target.value = "";
          }else{

            swal({
              title: "Error!",
              text: "Please Enter 5 Digit Number!",
              icon: "error",
              button: "Ok",
            });

          }

        }

      }else{

        if (event.target.value !== "") {
            setTags([...tags, event.target.value]);
            props.selectedTags([...tags, event.target.value]);
            event.target.value = "";
        }

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

	return (<App/>);

};


}
