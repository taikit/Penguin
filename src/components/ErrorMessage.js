var React = require('react');

var Error_message = React.createClass({
    render: function () {
        return (
            <div className="error_message">
                {this.props.message}
            </div>
        );
    }
});

module.exports = Error_message;
