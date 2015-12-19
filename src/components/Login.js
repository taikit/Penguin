var AuthActionCreators = require('../actions/AuthActionCreators');
var AuthStore = require('../stores/AuthStore');
var React = require('react');

function getStateFromStores() {
    console.log(AuthStore.get())
    return AuthStore.get()
}

var Login = React.createClass({
    getInitialState: function () {
        return {
            email: '',
            password: '',
        };
    },

    componentDidMount: function () {
        AuthStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function () {
        AuthStore.removeChangeListener(this._onChange);
    },

    render: function () {
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
            </form >
        );
    },

    _onChangeEmail: function (event, value) {
        this.setState({email: event.target.value});
    },
    _onChangePassword: function (event, value) {
        this.setState({password: event.target.value});
    },
    _onSubmitLogin: function () {
        event.preventDefault();
        AuthActionCreators.login(this.state.email, this.state.password);
    },
    _onChange: function () {
        this.setState(getStateFromStores());
    }
});
module.exports = Login;

