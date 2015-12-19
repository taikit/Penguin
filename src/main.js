//モジュールをインポート
var React = require('react');
var ReactDOM = require('react-dom');
var ReactRouter = require('react-router');
var Route = ReactRouter.Route;
var Router = ReactRouter.Router;
var IndexRoute = ReactRouter.IndexRoute;

var Login = require('./components/Login');
var NotFound = require('./components/NotFound');

var App = React.createClass({
    render: function () {
        return (
            <div>
                {this.props.children}
            </div>
        )
    }
});

var routes = (
    <Route path="/" component={App}>
        <IndexRoute component={Login}/>
        <Route path="*" component={NotFound}/>
    </Route >
);

ReactDOM.render(<Router>{routes}</Router>, document.getElementById('content'));
