var React = require('react');
var ReactRouter = require('react-router');
var Router = ReactRouter.Router;
var Link = ReactRouter.Link;
var FontAwesome = require('react-fontawesome');

var MenuBar = React.createClass({
    get_title: function () {
        switch (this.props.location.pathname) {
            case '/rooms':
                return 'Chat';
            default:
                return 'Penguin';
        }
    },

    render: function () {
        return (
            <ul className="header">
                <li className="header-left">
                </li>
                <li className="header-center">
                    <span>{this.get_title()}</span>
                </li>
                <li className="header-right">
                    <FontAwesome name='plus'/>
                </li>
            </ul>
        )
    }
});

module.exports = MenuBar;
