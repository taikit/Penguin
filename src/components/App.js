var React = require('react');
var AuthActionCreators = require('../actions/AuthActionCreators');
var MenuBar = require('../components/MenuBar');

var App = React.createClass({
    render: function () {
        return (
            <div className="app">
                <div className="main">
                    {this.props.children}
                </div>
                <MenuBar />
            </div>
        )
    },
    _onClickLogOut: function () {
        AuthActionCreators.logout();
    }
});

module.exports = App;
