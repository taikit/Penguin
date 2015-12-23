var React = require('react');
var Link = require('react-router').Link;
var RoomStore = require('../stores/RoomStore');

var Room = React.createClass({
        componentDidMount: function () {
            RoomStore.addChangeListener(this._onChange);
        },
        componentWillUnmount: function () {
            RoomStore.removeChangeListener(this._onChange);
        },
        get_room_name: function () {
            var name = this.props.data.room_name;
            if (this.props.data.member_count) {
                name += '(' + this.props.data.member_count + ')';
            }
            return name;
        },
        get_message_path: function () {
            var room_id = this.props.data.room_id;
            return "messages/" + room_id;
        },
        render: function () {
            return (
                <li className="room">
                    <Link to={this.get_message_path()}>
                        <div className="room-image">
                            <img src="http://dummyimage.com/200x200/999/fff.png&text=GroupImage"/>
                        </div>
                        <div className="room-detail">
                            <p className="room-name">
                                {this.get_room_name()}
                            </p>
                            <p className="room-content">
                                {this.props.data.last_message_content}
                            </p>
                        </div>
                    </Link>
                </li>
            );
        }
        ,
        _onChange: function () {
        }
    })
    ;

module.exports = Room;
