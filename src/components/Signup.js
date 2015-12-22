var React = require('react');
var ReactCSSTransitionGroup = require('react-addons-css-transition-group');

var AuthActionCreators = require('../actions/AuthActionCreators');
var AuthStore = require('../stores/AuthStore');

function getStateFromStores() {
    return AuthStore.get()
}

var Signup = React.createClass({

    getInitialState: function () {
        return {
            message: false,
            name: '',
            email: '',
            password: ''
        };
    },

    componentDidMount: function () {
        AuthStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function () {
        AuthStore.removeChangeListener(this._onChange);
    },

    render: function () {
        var message;
        if (this.state.message) {
            message = (
                <p>{this.state.message}</p>
            );
        }

        return (
            <form className="SingUp" onSubmit={this._onSubmitSingUp}>
                <input type="text"
                       placeholder="Email"
                       value={this.state.email}
                       onChange={this._onChangeEmail}/>
                <input type="text"
                       placeholder="name"
                       value={this.state.name}
                       onChange={this._onChangeName}/>
                <input type="password"
                       placeholder="Password"
                       value={this.state.password}
                       onChange={this._onChangePassword}/>
                <input type="submit" value="Sing up"/>
                <ReactCSSTransitionGroup transitionName="shake" transitionEnterTimeout={500}
                                         transitionLeaveTimeout={300}>
                    {message}
                </ReactCSSTransitionGroup>
            </form >
        );
    },

    _onChangeEmail: function (event, value) {
        this.setState({email: event.target.value});
    },
    _onChangePassword: function (event, value) {
        this.setState({password: event.target.value});
    },
    _onChangeName: function (event, value) {
        this.setState({name: event.target.value});
    },
    _onSubmitSingUp: function (event) {
        event.preventDefault();
        this.setState({message: ''});
        AuthActionCreators.signup(this.state.email, this.state.password, this.state.name);
    },
    _onChange: function () {
        this.setState(getStateFromStores());
    }
});
module.exports = Signup;

