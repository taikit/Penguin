var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');


var RoomStore = require('../stores/RoomStore');

var ActionTypes = Constants.ActionTypes;
var CHANGE_EVENT = 'change';

var _messages = [];

var MessageStore = assign({}, EventEmitter.prototype, {

    emitChange: function () {
        this.emit(CHANGE_EVENT);
    },

    addChangeListener: function (callback) {
        this.on(CHANGE_EVENT, callback);
    },

    removeChangeListener: function (callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    set_messages: function (messages_data, room_id) {
        messages_data.forEach(function (message) {
            message['room_id'] = room_id;
            _messages[message.id] = message;
        });
    },

    get_messages: function () {
        var res = [];
        _messages.forEach(function (message) {
            if (RoomStore.current_id() == message.room_id) {
                res.push(message)
            }
        });
        return res;
    }
});

MessageStore.dispatchToken = Dispatcher.register(function (action) {
    switch (action.type) {

        case ActionTypes.GET_MESSAGES:
            Dispatcher.waitFor([RoomStore.dispatchToken]);
            MessageStore.set_messages(action.data, action.room_id);
            MessageStore.emitChange();
            break;

        default:
        // do nothing
    }
});

module.exports = MessageStore;

