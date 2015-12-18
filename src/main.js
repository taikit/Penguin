//モジュールをインポート
var $ = require('jquery')
var React = require('react');
var ReactDOM = require('react-dom');
var ReactRouter = require('react-router');
var Router = ReactRouter.Router;
var Route = ReactRouter.Route;
var IndexRoute = ReactRouter.IndexRoute;
var Link = ReactRouter.Link;

var API = require('./api');

var App = React.createClass({
    render: function () {
        return (
            <div>
                {this.props.children}
            </div>
        )
    }
});

var Login = React.createClass({
    getInitialState: function () {
        return {email: '', password: '', trans: ''};
    },
    handleEmailChange: function (e) {
        this.setState({email: e.target.value});
    },
    handlePasswordChange: function (e) {
        this.setState({password: e.target.value});
    },
    handleAuthError: function () {
        this.setState({
            error_message: <ErrorMessage message="メールアドレスかパスワードが間違っています"/>
        });
    },
    handleLoginSubmit: function () {
        var data = {
            "email": this.state.email.trim(),
            "password": this.state.password.trim()
        };
        var handleAuthError = this.handleAuthError();
        API.exec("user", "login", data).done(function (e) {
            e.data ? console.log(e) : handleAuthError
        });
    },
    render: function () {
        return (
            <form className="loginForm" onSubmit={this.handleLoginSubmit}>
                <input type="text"
                       placeholder="メールアドレス"
                       value={this.state.email}
                       onChange={this.handleEmailChange}/>
                <input type="password"
                       placeholder="パスワード"
                       value={this.state.password}
                       onChange={this.handlePasswordChange}/>
                <input type="submit" value="ログイン"/>
                {this.state.error_message}
                {this.state.trans}
            </form >
        );
    }
});

var ErrorMessage = React.createClass({
    render: function () {
        return (
            <div className="error_message">
                {this.props.message}
            </div>
        );
    }
});

var MessageList = React.createClass({
    render: function () {
        var messageNodes = this.props.data.map(function (message) {
            return (
                <Message author={message.author}>
                    {message.text}
                </Message>
            );
        });
        return (
            <div className="messageList">
                {messageNodes}
            </div>
        );
    }
});

var MessageForm = React.createClass({
    getInitialState: function () {
        return {author: '', text: ''};
    },
    handleAuthorChange: function (e) {
        this.setState({author: e.target.value});
    },
    handleTextChange: function (e) {
        this.setState({text: e.target.value});
    },
    handleSubmit: function (e) {
        e.preventDefault();
        var author = this.state.author.trim();
        var text = this.state.text.trim();
        if (!text || !author) {
            return;
        }
        this.props.onMessageSubmit({author: author, text: text});
        this.setState({author: '', text: ''});
    },
    render: function () {
        return (
            <form className="messageForm" onSubmit={this.handleSubmit}>
                <input type="text"
                       placeholder="Your name"
                       value={this.state.author}
                       onChange={this.handleAuthorChange}/>
                <input type="text"
                       placeholder="Say something..."
                       value={this.state.text}
                       onChange={this.handleTextChange}/>
                <input type="submit" value="Post"/>
            </form>
        );
    }
});

var Message = React.createClass({
    render: function () {
        var rawMarkup = marked(this.props.children.toString(), {sanitize: true});
        return (
            <div className="message">
                <h2 className="messageAuthor">
                    {this.props.author}
                </h2>
                <span dangerouslySetInnerHTML={{__html: rawMarkup}}/>
            </div>
        );
    }
});

var MessageBox = React.createClass({
    loadMessagesFromServer: function () {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            cache: false,
            success: function (data) {
                this.setState({data: data});
            }.bind(this),
            error: function (xhr, status, err) {
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    },
    handleMessageSubmit: function (message) {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
            type: 'POST',
            data: message,
            success: function (data) {
                this.setState({data: data});
            }.bind(this),
            error: function (xhr, status, err) {
                console.error(this.props.url, status, err, toString());
            }.bind(this)
        });
    },
    getInitialState: function () {
        return {data: []}
    },
    //ComponentがDOMツリーに追加された状態で呼ばれるのでDOMに関わる初期化処理
    componentDidMount: function () {
        this.loadMessagesFromServer();
        setInterval(this.loadMessagesFromServer, this.props.pollInterval);
    },
    render: function () {
        return (
            <div className="messageBox">
                <h1>Messages</h1>
                <MessageList data={this.state.data}/>
                <MessageForm onMessageSubmit={this.handleMessageSubmit}/>
            </div>
        );
    }
});

var NotFound = React.createClass({
    render: function () {
        return (<div>NOT FOUND</div>);
    }
});

var routes = (
    <Route path="/" component={App}>
        <IndexRoute component={Login}/>
        <Route path="message" component={MessageBox}/>
        <Route path="*" component={NotFound}/>
    </Route >
);

ReactDOM.render(<Router>{routes}</Router>, document.getElementById('content'));


