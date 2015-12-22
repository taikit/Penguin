var React = require('react');
var AuthStore = require('../stores/AuthStore');
var AuthActionCreators = require('../actions/AuthActionCreators');

var Rooms = React.createClass({
    componentDidMount: function () {
        AuthStore.addChangeListener(this._onChange);
    },

    render: function () {

        return (
            <div onclick={this._test}>
                <button onClick={this._test}/>
                this is rooms
            </div>
        );
    },
    _test: function () {
        AuthActionCreators.get_status()
    },
    _onChange: function(){
        console.log(Date.now());
        console.log(AuthStore.get_status());
    }
});

module.exports = Rooms;
