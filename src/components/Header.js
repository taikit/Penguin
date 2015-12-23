var React = require('react');
var Link = require('react-router').Link;
var FontAwesome = require('react-fontawesome');

var MenuBar = React.createClass({
    render: function () {
        return (
            <div className="header">
                <div className="header-left">
                </div>
                <div className="header-left">
                    {this.props.children}
                </div>
                <div className="header-left">
                    <FontAwesome name='plus'/>
                </div>
            </div>
        )
    }
});

module.exports = MenuBar;
