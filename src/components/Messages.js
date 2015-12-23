var React = require('react');
var MessageStore = require('../stores/MessageStore');
var MessageActionCreators = require('../actions/MessageActionCreators');
var Message = require('../components/Message');
var Messages = React.createClass({
    getInitialState: function () {
        return {messages: []}
    },
    componentDidMount: function () {
        MessageStore.addChangeListener(this._onChange);
        MessageActionCreators.get();
    },
    componentWillUnmount: function () {
        MessageStore.removeChangeListener(this._onChange);
    },

    render: function () {
        var messageNodes = this.state.messages.map(function (message) {
            return (
                <Message data={message} key={message.message_id}/>
            )
        });
        return (
            <div className="messages">
                {messageNodes}
            </div>
        );
    },
    _onChange: function () {
        //this.setState({messages: MessageStore.get_messages()});
    }
});

module.exports = Messages;
