var React = require('react');
var MessageStore = require('../stores/MessageStore');
var MessageActionCreators = require('../actions/MessageActionCreators');
var Message = require('../components/Message');
var MessageOutbox = require('../components/MessageOutbox');
var Messages = React.createClass({
    getInitialState: function () {
        return {messages: []}
    },
    componentDidMount: function () {
        MessageStore.addChangeListener(this._onChange);
        MessageActionCreators.get(this.props.params.room_id, null);
    },
    componentWillUnmount: function () {
        MessageStore.removeChangeListener(this._onChange);
    },

    render: function () {
        var messageNodes = this.state.messages.map(function (message) {
            return (
                <Message data={message} key={message.id}/>
            )
        });
        return (
            <div>
                <ul className="messages">
                    {messageNodes}
                </ul>
                <MessageOutbox data={this.props.params.room_id}/>
            </div>
        );
    },
    _onChange: function () {
        this.setState({messages: MessageStore.get_messages()});
    }
});

module.exports = Messages;
