//モジュールをインポート
var React = require('react');
var ReactDOM = require('react-dom');
var ReactRouter = require('react-router');
var Route = ReactRouter.Route;
var Router = ReactRouter.Router;
var IndexRoute = ReactRouter.IndexRoute;

var APIUtils = require('./utils/APIUtils');

var History = ReactRouter.History;

var AuthStore = require('./stores/AuthStore');
var AuthActionCreators = require('./actions/AuthActionCreators');

var Login = require('./components/Login');
var Signup = require('./components/Signup');
var App = require('./components/App');
var Rooms = require('./components/Rooms');
var Messages = require('./components/Messages');
var NotFound = require('./components/NotFound');


var Base = React.createClass({
        mixins: [History],

        componentDidMount: function () {
            AuthStore.addChangeListener(this._onAuthChange);
            AuthActionCreators.get_status();
        },
        componentWillUnmount: function () {
            AuthStore.removeChangeListener(this._onAuthChange);
        },
        componentDidUpdate: function () {
            this._AuthCheck();
        },
        current_path: function () {
            return this.props.location.pathname;
        },

        render: function () {
            return (
                <div className="app">
                    {this.props.children}
                </div>
            )
        },
        _onAuthChange: function () {
            this._AuthCheck();
            if (AuthStore.get_status()) {
                this.props.history.replaceState(null, '/rooms');
            }
        },
        _AuthCheck: function () {
            if (!AuthStore.get_status() && this.current_path() != '/login' && this.current_path() != 'signup' && this.current_path() != '/signup') {
                this.props.history.replaceState(null, '/login');
            }
        }
    })
    ;

var routes = (
    <Route path="/" component={Base}>
        <IndexRoute component={Login}/>
        <Route path="signup" component={Signup}/>
        <Route component={App}>
            <Route path="messages/:room_id" component={Messages}/>
            <Route path="rooms" component={Rooms}/>
        </Route>
        <Route path="login" component={Login}/>
        <Route path="*" component={NotFound}/>
    </Route>
);

ReactDOM.render(
    <Router>{routes}</Router>,
    document.getElementById('content')
);

