var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var APIUtils = require('../utils/APIUtils');

var ActionTypes = Constants.ActionTypes;

module.exports = {
    get: function (room_id, last_message_id) {
        APIUtils.get_messages(room_id, last_message_id).done(function (event) {
            Dispatcher.dispatch({
                type: ActionTypes.GET_MESSAGES,
                data: event.data
            });
        });
    },
    submit: function (message, room_id) {
        APIUtils.create_message(message.trim(), room_id).done(function (event) {
            Dispatcher.dispatch({
                type: ActionTypes.CREATE_MESSAGE,
                room_id: room_id,
                message: message
            });
        })
    }
};