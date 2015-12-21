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
var App = require('./components/App');
var Rooms = require('./components/Rooms');
var NotFound = require('./components/NotFound');


var Base = React.createClass({
    mixins: [History],

    componentDidMount: function () {
        AuthStore.addChangeListener(this._onChange);
        AuthActionCreators.get_status()
    },

    render: function () {
        return (
            <div>
                {this.props.children}
            </div>
        )
    },
    _onChange: function () {
        if (AuthStore.get_status()) {
            this.history.replaceState(null, '/app/rooms');
        }
    }
});


function requireAuth(nextState, replaceState) {
    if (!AuthStore.get_status())
        replaceState({ nextPathname: nextState.location.pathname }, '/login')
}

var routes = (
    <Route path="/" component={Base}>
        <IndexRoute component={Login}/>
        <Route path="app" component={App} onEnter={requireAuth}>
            <Route path="rooms" component={Rooms}/>
        </Route>
        <Route path="login" component={Login}/>
        <Route path="*" component={NotFound}/>
    </Route>
);

ReactDOM.render(
    <Router >{routes}</Router>,
    document.getElementById('content')
);