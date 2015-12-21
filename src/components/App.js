var React = require('react');

var App = React.createClass({
    render: function () {
        return (
            <div>
                {this.props.children}
                <div className="menubar">
                    this is menu bar
                </div>
            </div>

        )
    }
});

module.exports = App;
