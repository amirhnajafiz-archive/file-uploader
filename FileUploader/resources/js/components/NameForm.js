import * as React from "react";

class NameForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            title: '',
            description: '',
            image: undefined,
            file: undefined
        };
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        name = event.target.name;
        this.setState({[name]: event.target.value});
    }

    handleSubmit(event) {
        alert('A name was submitted: ' + this.state.title + this.state.description);
        event.preventDefault();
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit}>
                <div className="row px-3 my-3">
                    <label>
                        File Title
                    </label>
                    <input type="text" name="title" className="form-control" placeholder="Title ..." value={this.state.title}
                           onChange={this.handleChange}/>
                </div>
                <div className="row px-3 my-3">
                    <label>
                        Description about file
                    </label>
                    <textarea name="description" className="form-control" placeholder="Write something ..."
                              value={this.state.description}
                              onChange={this.handleChange}
                    />
                </div>
                <div className="row px-3 my-3">
                    <label>
                        Set an image for the file (optional)
                    </label>
                    <input name="image" type="file" className="form-control" value={this.state.image}
                           onChange={this.handleChange}
                    />
                </div>
                <div className="row px-3 my-3">
                    <label>
                        Upload your file
                    </label>
                    <input name="file" type="file" className="form-control" value={this.state.file}
                           onChange={this.handleChange}
                    />
                </div>
                <input type="submit" value="Submit" className="btn btn-success mt-2"/>
            </form>
        );
    }
}

export default NameForm;
