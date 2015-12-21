var $ = require("jquery");
var Constants = require('../constants/Constants');

var API = function (model, action, data) {
    return $.ajax({
        url: Constants.APIEndpoint + '?model=' + model + '&action=' + action,
        dataType: 'json',
        type: 'POST',
        data: {data: JSON.stringify(data)},
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
            password: password
        };
        return API('user', 'login', data);
    }
};