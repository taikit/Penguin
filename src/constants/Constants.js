var keyMirror = require('keymirror');

module.exports = {
    APIEndpoint: "https://penguin-tus.azurewebsites.net/api/index.php",

    ActionTypes: keyMirror({
        LOGIN_SUCCESS: null,
        LOGIN_FAIL: null,
        SIGNUP_SUCCESS: null,
        SIGNUP_FAIL: null,
        LOGOUT: null,
        AUTH_STATUS: null
    })
};