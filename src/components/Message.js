var React = require('react');
var MessageStore = require('../stores/MessageStore');

var Message = React.createClass({
        componentDidMount: function () {
            MessageStore.addChangeListener(this._onChange);
        },
        componentWillUnmount: function () {
            MessageStore.removeChangeListener(this._onChange);
        },
        render: function () {
            return (
                <li className="message">
                        <div className="message-image">
                            <img src="http://dummyimage.com/200x200/999/fff.png&text=GroupImage"/>
                        </div>
                        <div className="message-detail">
                            <p className="message-name">
                            </p>
                            <p className="message-content">

                                {console.log(this.props.data)}
                                {this.props.data.last_message_content}
                            </p>
                        </div>
                </li>
            );
        },
        _onChange: function () {
        }
    })
    ;

module.exports = Message;
