<template>
    <div class="container">
        <div class="row justify-content-center">
            <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Create New Room</button>
            <!-- Modal -->
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create new Chat Room</h5>
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
            <button @click="flag = !flag" v-if="selectedRoom.hasOwnProperty('name')" class="btn btn-info" data-toggle="modal" data-target="#editModal">Edit Room</button>
            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Chat Room <strong>{{ selectedRoom.name }}</strong></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <members-in-room v-if="selectedRoom.hasOwnProperty('id')" @membersChanged="checkedForUpdating = $event"></members-in-room>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button @click="deleteRoom" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
                            <button @click="updateRoom(checkedForUpdating)" type="button" class="btn btn-primary" data-dismiss="modal">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <select @change="roomChanged(selectedRoom.id)" v-model="selectedRoom">
                <option disabled value="">Please select room</option>
                <option v-for="room in rooms" :value="room">{{room.name}}</option>
            </select><br>

            <div class="card-header">Room name: {{ selectedRoom.name }} ({{ selectedRoom.id }})</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:100px">Photo</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="member in members">
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
               checkedForUpdating: [],
               flag: false,
           }
       },
        computed: {

        },
        watch: {
            flag: function() {
                eventBus.$emit('getMembersFriends');

            }
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
            roomChanged: function (id) {
                axios({
                    method: 'get',
                    url:    '/frontend/chat/rooms/get-members',
                    params: {room_id: this.selectedRoom.id}
                }).then((response) => {
                    this.members = response.data.members;
                    eventBus.$emit('roomChanged', id);
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

            updateRoom: function (checked) {
                axios({
                    method: 'put',
                    url:    '/frontend/chat/rooms/update-room',
                    params: {checked: checked, room_id: this.selectedRoom.id}
                }).then((response) => {
                   console.log(response.data.updatedMembersIds);
                });
            },
            deleteRoom: function (checked) {
                axios({
                    method: 'delete',
                    url:    '/frontend/chat/rooms/delete-room',
                    params: {checked: checked, room_id: this.selectedRoom.id}
                }).then((response) => {
                    this.rooms = response.data.rooms;
                });
            },

        }
    }
</script>
