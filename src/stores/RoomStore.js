var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var ActionTypes = Constants.ActionTypes;
var CHANGE_EVENT = 'change';

var _rooms;

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
    }

});

RoomStore.dispatchToken = Dispatcher.register(function (action) {
    switch (action.type) {

        case ActionTypes.GET_ROOMS:
            _rooms = action.data;
            RoomStore.emitChange();
            break;

        default:
        // do nothing
    }
});

module.exports = RoomStore;

