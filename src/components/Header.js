var React = require('react');
var Link = require('react-router').Link;
var FontAwesome = require('react-fontawesome');

var MenuBar = React.createClass({
    render: function () {
        return (
            <ul className="header">
                <li className="header-left">
                </li>
                <li className="header-center">
                    <span>Chats</span>
                </li>
                <li className="header-right">
                    <FontAwesome name='plus'/>
                </li>
            </ul>
        )
    }
});

module.exports = MenuBar;
