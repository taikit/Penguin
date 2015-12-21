
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
