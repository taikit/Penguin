var keyMirror = require('keymirror');

module.exports = {
    APIEndpoint: "http://localhost:8080/api/",

    ActionTypes: keyMirror({
        LOGIN_SUCCESS: null,
        LOGIN_FAIL: null,
        SIGNUP_SUCCESS: null,
        SIGNUP_FAIL: null,
        LOGOUT: null,
        AUTH_STATUS: null
    })
};