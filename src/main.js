//モジュールをインポート
var React = require('react');
var ReactDOM = require('react-dom');
var ReactRouter = require('react-router');
var Route = ReactRouter.Route;
var Router = ReactRouter.Router;
var IndexRoute = ReactRouter.IndexRoute;

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
        AuthStore.addChangeListener(this._onChange);
        AuthActionCreators.get_status()
    },

    componentWillUnmount: function () {
        AuthStore.removeChangeListener(this._onChange);
    },

    render: function () {
        return (
            <div className="app">
                {this.props.children}
            </div>
        )
    },
    _onChange: function () {
        if (AuthStore.get_status()) {
            this.history.replaceState(null, 'rooms');
        } else {
            this.history.replaceState(null, '/');
        }
    }
});


function requireAuth(nextState, replaceState) {
    if (!AuthStore.get_status()) {
        replaceState({nextPathname: nextState.location.pathname}, '/login')
    }
}

var routes = (
    <Route path="/" component={Base}>
        <IndexRoute component={Login}/>
        <Route path="signup" component={Signup}/>
        <Route component={App} onEnter={requireAuth}>
            <Route path="rooms" component={Rooms}/>
        </Route>
        <Route path="messages" component={Messages} onEnter={requireAuth}/>
        <Route path="login" component={Login}/>
        <Route path="*" component={NotFound}/>
    </Route>
);

ReactDOM.render(
    <Router>{routes}</Router>,
    document.getElementById('content')
);