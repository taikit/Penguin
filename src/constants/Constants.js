var keyMirror = require('keymirror');
var hostName = document.location.hostname;
function get_endpoint() {
    if (hostName == "localhost" || hostName == "127.0.0.1") {
        return "http://" + hostName + ":8080/api/index.php";
    } else {
        return "https://penguin-tus.azurewebsites.net//api/index.php";
    }
}
module.exports = {
    APIEndpoint: get_endpoint(),

    ActionTypes: keyMirror({
        LOGIN_SUCCESS: null,
        LOGIN_FAIL: null,
        SIGNUP_SUCCESS: null,
        SIGNUP_FAIL: null,
        LOGOUT: null,
        AUTH_STATUS: null
    })
};