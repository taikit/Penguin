var React = require('react');
var MenuBar = require('../components/MenuBar');

var App = React.createClass({
    render: function () {
        return (
            <div className="app">
                <div className="main">
                    {thisA.props.children}
                </div>
                <MenuBar />
            </div>
        )
    }
});

module.exports = App;
