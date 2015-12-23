var React = require('react');
var RoomStore = require('../stores/RoomStore');
var RoomActionCreators = require('../actions/RoomActionCreators');
var Room = require('../components/Room');

var Rooms = React.createClass({
    getInitialState: function () {
        return {rooms: []}
    },
    componentDidMount: function () {
        RoomStore.addChangeListener(this._onChange);
        RoomActionCreators.get();
    },
    componentWillUnmount: function () {
        RoomStore.removeChangeListener(this._onChange);
    },

    render: function () {
        var roomNodes = this.state.rooms.map(function (room) {
            return (
                <Room data={room} key={room.room_id}/>
            )
        });
        return (
            <ul className="rooms">
                {roomNodes}
            </ul>
        );
    },
    _onChange: function () {
        this.setState({rooms: RoomStore.get_rooms()});
    }
});

module.exports = Rooms;
