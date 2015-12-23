var React = require('react');
var Link = require('react-router').Link;
var FontAwesome = require('react-fontawesome');

var MenuBar = React.createClass({
    render: function () {
        return (
            <div className="menubar">
                <ul>
                    <li>
                        <Link to="">
                            <FontAwesome name='users'/>
                            <span>Friends</span>
                        </Link>
                    </li>
                    <li>
                        <Link to="rooms">
                            <FontAwesome name='comment'/>
                            <span>Chats</span>
                        </Link>
                    </li>
                    <li>
                        <Link to="">
                            <FontAwesome name='ellipsis-h'/>
                            <span>More</span>
                        </Link>
                    </li>
                    <li>
                        <div className="pointer" onClick={this._onClickLogOut}>
                            <FontAwesome name='sign-out'/>
                            <span>Log out</span>
                        </div>
                    </li>
                </ul>
            </div>
        )
    }
});

module.exports = MenuBar;
