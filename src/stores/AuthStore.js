var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');

var ActionTypes = Constants.ActionTypes;
var CHANGE_EVENT = 'change';

var _current_user_id = '';
var _message;

var AuthStore = assign({}, EventEmitter.prototype, {

    emitChange: function () {
        this.emit(CHANGE_EVENT);
    },

    addChangeListener: function (callback) {
        this.on(CHANGE_EVENT, callback);
    },

    removeChangeListener: function (callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    get_status: function () {
        return !!_current_user_id
    },

    get: function () {
        return {
            current_user_id: _current_user_id,
            message: _message
        };
    }
});

AuthStore.dispatchToken = Dispatcher.register(function (action) {
    switch (action.type) {
        case ActionTypes.LOGIN_SUCCESS:
            AuthStore.emitChange();
            break;

        case ActionTypes.LOGIN_FAIL:
            _current_user_id = null;
            _message = action.message;
            AuthStore.emitChange();
            break;

        case ActionTypes.SIGNUP_SUCCESS:
            AuthStore.emitChange();
            break;

        case ActionTypes.SIGNUP_FAIL:
            _message = action.message;
            AuthStore.emitChange();
            break;


        case ActionTypes.AUTO_STATUS:
            if(_current_user_id != action.current_user_id){
                _current_user_id = action.current_user_id;
                AuthStore.emitChange();
            }
            break;


        case ActionTypes.AUTH_STATUS:
            if(_current_user_id != action.current_user_id){
                _current_user_id = action.current_user_id;
                AuthStore.emitChange();
            }
            break;

        default:
        // do nothing
    }

});

module.exports = AuthStore;

