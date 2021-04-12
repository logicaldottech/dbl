import React from 'react';
import ReactDOM from 'react-dom';

function Example() {

  const REACT_VERSION = React.version;

    return (

        <div className="container">
        {REACT_VERSION}
        </div>
    );
}

export default Example;

if (document.getElementById('search-sidebar-buttons')) {
    ReactDOM.render(<Example />, document.getElementById('search-sidebar-buttons'));
}
