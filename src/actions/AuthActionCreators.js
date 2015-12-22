var Dispatcher = require('../dispatcher/Dispatcher');
var Constants = require('../constants/Constants');
var APIUtils = require('../utils/APIUtils');


var ActionTypes = Constants.ActionTypes;

module.exports = {

    login: function (email, password) {
        APIUtils.login(email.trim(), password.trim()).done(function (event) {
            if (event.data) {
                Dispatcher.dispatch({
                    type: ActionTypes.LOGIN_SUCCESS,
                    current_user_id: event.session.user_id
                });
            } else {
                Dispatcher.dispatch({
                    type: ActionTypes.LOGIN_FAIL,
                    message: 'メールアドレスかパスワードが間違っています'
                });
            }
        });
    },
    logout: function () {
        APIUtils.logout().done(function (event) {
            Dispatcher.dispatch({
                type: ActionTypes.LOGOUT,
                current_user_id: event.session.user_id
            });
        });
    },
    signup: function (email, password, name) {
        APIUtils.signup(email.trim(), password.trim(), name.trim()).done(function (event) {
            if (event.data) {
                Dispatcher.dispatch({
                    type: ActionTypes.SIGNUP_SUCCESS,
                    current_user_id: event.session.user_id
                });
            } else {
                Dispatcher.dispatch({
                    type: ActionTypes.LOGIN_FAIL,
                    message: 'このメールアドレスはすでに登録されています'
                });
            }
        });
    },
    get_status: function () {
        APIUtils.status();
    }
};