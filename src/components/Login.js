var React = require('react');
var ReactRouter = require('react-router');
var ReactCSSTransitionGroup = require('react-addons-css-transition-group');

var AuthActionCreators = require('../actions/AuthActionCreators');
var AuthStore = require('../stores/AuthStore');

function getStateFromStores() {
    return AuthStore.get()
}

var Login = React.createClass({

    getInitialState: function () {
        return {
            status: false,
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
                       placeholder="メールアドレス"
                       value={this.state.email}
                       onChange={this._onChangeEmail}/>
                <input type="password"
                       placeholder="パスワード"
                       value={this.state.password}
                       onChange={this._onChangePassword}/>
                <input type="submit" value="ログイン"/>
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

