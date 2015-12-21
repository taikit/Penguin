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

    get_status: function (){
        APIUtils.status();
    },

    status_change: function(event){
    }
};