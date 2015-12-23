var React = require('react');
var RoomStore = require('../stores/RoomStore');

var Rooms = React.createClass({
        componentDidMount: function () {
            RoomStore.addChangeListener(this._onChange);
        },
        componentWillUnmount: function () {
            RoomStore.removeChangeListener(this._onChange);
        },
        get_room_name: function () {
            var name = this.props.data.room_name;
            if (this.props.data.member_ccount) {
                //TODO ccount
                name += '(' + this.props.data.member_ccount + ')';
            }
            return name;
        },
        render: function () {
            return (
                <li className="room">
                    <div className="room-image">
                        <img src="http://dummyimage.com/200x200/999/fff.png&text=GroupImage"/>
                    </div>
                    <div className="room-detail">
                        <p className="room-name">
                            {this.get_room_name()}
                        </p>
                        <p className="room-content">
                            {this.props.data.content}
                        </p>
                    </div>
                </li>
            );
        }
        ,
        _onChange: function () {
        }
    })
    ;

module.exports = Rooms;
