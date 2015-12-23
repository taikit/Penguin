var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var APIUtils = require('../utils/APIUtils');

var ActionTypes = Constants.ActionTypes;

module.exports = {
    get: function () {
        APIUtils.get_rooms().done(function (event) {
            Dispatcher.dispatch({
                type: ActionTypes.GET_ROOMS,
                data: event.data
            });
        });

    }
};