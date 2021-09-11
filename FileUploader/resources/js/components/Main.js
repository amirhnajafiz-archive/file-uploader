import React from 'react';
import ReactDOM from 'react-dom';
import NameForm from './NameForm';

function Main() {
    return (
        <div className="container">
            <div className="row justify-content-center mt-2">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">File upload</div>

                        <div className="card-body">
                            <NameForm />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Main;

if (document.getElementById('example')) {
    ReactDOM.render(<Main />, document.getElementById('example'));
}
