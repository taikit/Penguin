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
                        <img src="http://dummyimage.com/200x200/999/fff.png&text=User"/>
                    </div>
                    <div className="message-detail">
                        <p className="message-name">
                            {this.props.data.name}
                        </p>
                        <p className="message-content">
                            {this.props.data.content}
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
