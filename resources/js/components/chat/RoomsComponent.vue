<template>
    <div class="container">
        <div class="row justify-content-center">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Create New Room</button>
            <select @change="roomChanged" v-model="selectedRoom">
                <option disabled value="">Please select room</option>
                <option v-for="room in rooms" :value="room">{{room.name}}</option>
            </select><br>

            <div class="card-header">Room name: {{ selectedRoom.name }}</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:100px">Photo</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="member in members" >
                        <td>
                            <a :href="member.photo">
                                <img :src="member.thumbnail" alt="Photo" style="width:100%">
                            </a>
                        </td>
                        <td>{{ member.name }}</td>
                    </tr>

                    </tbody>
                </table>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create new Chat Room</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input v-model="roomName" placeholder="Room name">

                            <friends-for-room @friendsList="checked = $event"></friends-for-room>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button @click="createRoom()" type="button" class="btn btn-primary" data-dismiss="modal">Create</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import { eventBus } from "../../app";

    export default {
        props: {

        },

       data: function(){
           return {
               selectedRoom: {},
               rooms: [],
               members: [],
               roomName: '',
               friends: [],
               checked: [],
           }
       },
        computed: {

        },

        mounted() {
           this.getRooms();
        },

        methods:  {

            getRooms: function () {
                axios({
                    method: 'get',
                    url:    '/frontend/chat/rooms/get-rooms',
                }).then((response) => {
                    this.rooms = response.data.rooms;
                });

            },
            roomChanged: function () {
                console.log(this.selectedRoom);
                axios({
                    method: 'get',
                    url:    '/frontend/chat/rooms/get-members',
                    params: {room_id: this.selectedRoom.id}
                }).then((response) => {
                    this.members = response.data.members;
                    console.log(this.members);
                });

            },

            createRoom: function () {
                axios({
                    method: 'post',
                    url:    '/frontend/chat/rooms/create-room',
                    params: {checked: this.checked, roomName: this.roomName}
                }).then((response) => {
                    this.rooms = response.data.rooms;
                });
                eventBus.$emit('resetCheckedFriends');
                this.roomName = '';
            },

        }
    }
</script>
