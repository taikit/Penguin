var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var ActionTypes = Constants.ActionTypes;
var CHANGE_EVENT = 'change';

var _rooms = [];
var _current_room_id;

var RoomStore = assign({}, EventEmitter.prototype, {

    emitChange: function () {
        this.emit(CHANGE_EVENT);
    },

    addChangeListener: function (callback) {
        this.on(CHANGE_EVENT, callback);
    },

    removeChangeListener: function (callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    get_rooms: function () {
        return _rooms;
    },

    set_rooms: function (rooms_data) {
        rooms_data.forEach(function (room) {
            _rooms[room.room_id] = room;
        });
    },
    current_id: function(){
        return _current_room_id
    }

});

RoomStore.dispatchToken = Dispatcher.register(function (action) {
    switch (action.type) {

        case ActionTypes.GET_ROOMS:
            RoomStore.set_rooms(action.data);
            RoomStore.emitChange();
            break;

        case ActionTypes.GET_MESSAGES:
            _current_room_id = action.room_id;
            break;

        default:
        // do nothing
    }
});

module.exports = RoomStore;

