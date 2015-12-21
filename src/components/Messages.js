var React = require('react');
var FontAwesome = require('react-fontawesome');

var Messages = React.createClass({
    render: function () {
        return (
            <div>
                <FontAwesome
                    className='super-crazy-colors'
                    name='rocket'
                    size='2x'
                    spin
                    style={{ textShadow: '0 1px 0 rgba(0, 0, 0, 0.1)' }}
                />
                this is messages
            </div>
        );
    }
});

module.exports = Messages;
