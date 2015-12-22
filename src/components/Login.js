var React = require('react');
var ReactCSSTransitionGroup = require('react-addons-css-transition-group');
var Link = require('react-router').Link;

var AuthActionCreators = require('../actions/AuthActionCreators');
var AuthStore = require('../stores/AuthStore');

function getStateFromStores() {
    return AuthStore.get()
}

var Login = React.createClass({

    getInitialState: function () {
        return {
            message: false,
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
            <form className="loginForm" onSubmit={this._onSubmitLogin}>
                <input type="text"
                       placeholder="Email"
                       value={this.state.email}
                       onChange={this._onChangeEmail}/>
                <input type="password"
                       placeholder="Password"
                       value={this.state.password}
                       onChange={this._onChangePassword}/>
                <input type="submit" value="Login"/>
                <ReactCSSTransitionGroup transitionName="shake" transitionEnterTimeout={500}
                                         transitionLeaveTimeout={300}>
                    {message}
                </ReactCSSTransitionGroup>
                <Link to="signup">
                    Sign up
                </Link>
            </form >
        );
    },

    _onChangeEmail: function (event, value) {
        this.setState({email: event.target.value});
    },
    _onChangePassword: function (event, value) {
        this.setState({password: event.target.value});
    },
    _onSubmitLogin: function (event) {
        event.preventDefault();
        this.setState({message: ''});
        AuthActionCreators.login(this.state.email, this.state.password);
    },
    _onChange: function () {
        this.setState(getStateFromStores());
    }
});
module.exports = Login;

