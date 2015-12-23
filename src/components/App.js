var React = require('react');
var MenuBar = require('../components/MenuBar');
var Header = require('../components/Header');

var App = React.createClass({
    render: function () {
        return (
            <div className="app">
                <Header />
                <div className="main">
                    {this.props.children}
                </div>
                <MenuBar />
            </div>
        )
    }
});

module.exports = App;
