var $ = require("jquery");
var Constants = require('../constants/Constants');
var Dispatcher = require('../dispatcher/Dispatcher');
var ActionTypes = Constants.ActionTypes;

var API = function (model, action, data) {
    return $.ajax({
        url: Constants.APIEndpoint + '?model=' + model + '&action=' + action,
        dataType: 'json',
        type: 'POST',
        data: {data: JSON.stringify(data)},
        success: function (event) {
            Dispatcher.dispatch({
                type: ActionTypes.AUTH_STATUS,
                current_user_id: event.session.user_id
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
};

module.exports = {

    login: function (email, password) {
        var data = {
            email: email,
            password: password,
        };
        return API('user', 'login', data);
    },

    logout: function () {
        var data = {};
        return API('user', 'logout', data);
    },

    status: function () {
        var data = {};
        return API('user', 'status', data);
    },
    signup: function (email, password, name) {
        var data = {
            email: email,
            password: password,
            name: name
        };
        return API('user', 'create', data);
    },
};