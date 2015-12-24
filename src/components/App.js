var React = require('react');
var MenuBar = require('../components/MenuBar');
var Header = require('../components/Header');
var MessageOutBox = require('../components/MessageOutBox');
var MessageStore = require('../stores/MessageStore');

var App = React.createClass({
    render: function () {
        if (this.props.location.pathname.match(/messages/)) {
            var footer = (<MessageOutBox />)
        } else {
            var footer = (<MenuBar />)
        }
        return (
            <div className="app">
                <Header location={this.props.location}/>
                <div className="main">
                    {this.props.children}
                </div>
                {footer}
            </div>
        )
    }
});

module.exports = App;
