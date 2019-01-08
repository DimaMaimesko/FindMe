<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">


                    <div class="card-header">Watch friends:</div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:100px">Photo</th>
                                <th>Name</th>
                                <th>Last Seen</th>
                                <th>add</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="friend in friends">
                                <td>
                                    <a :href="friend.photo">
                                        <img :src="friend.thumbnail" alt="Photo" style="width:100%">
                                    </a>
                                </td>
                                <td>{{ friend.name }}</td>
                                <td>{{}}</td>
                                <td>
                                    <!--<input-->
                                        <!--@change="changed(checkedAfter[friend.id], friend.id)"-->
                                        <!--v-model="checkedAfter[friend.id]" type="checkbox">-->
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { eventBus } from "../../app";
    export default {

        props: [
        ],

        data: function(){
            return {
                friends: [],
                // checked: [],
                // checkedAfter: [],
            }
        },
        methods: {
            getAllFriends:  function() {
                // console.log(id);
                axios({
                    method: 'get',
                    url:    '/frontend/map/get-all-friends',
                    //params: {room_id: id}
                }).then((response) => {
                    this.friends = response.data.friends;
                    // this.checked = response.data.checked;
                    // this.checkedAfter = [];
                    // this.checked.forEach((item, i) => {
                    //     this.checkedAfter[item] = true;
                    // });
                    // console.log('checked');
                    // console.log(this.checked);
                });
            },
            // changed: function (value, id) {
            //     if (this.checked.includes(id)){
            //         if (value == false){
            //             let index = this.checked.indexOf(id);
            //             if (index > -1) {
            //                 this.checked.splice(index, 1);
            //             }
            //         }
            //     }else{
            //         if (value == true){
            //             this.checked.push(id)
            //         }
            //     }
            //     //this.checkedAfter = this.checked;
            //     console.log("Checked" + this.checked);
            //     this.$emit('membersChanged', this.checked);
            // }


        },
        mounted() {
            this.getAllFriends();
            window.Echo.channel('coords-changed').listen('CoordsChanged', ({lat, lng, time, user_id}) => {
                console.log(lat);
                console.log(lng);
                console.log(time);
                console.log(user_id);
                // if ((typeof members) == "object"){
                //     if (members.includes(this.authId)){
                //         //this.roomChanged(this.selectedRoom.id);
                //         this.getRooms();
                //         console.log('Updated');
                //     }
                // }else{
                //     console.log('Removed');
                //     this.members = [];
                //     let index = this.rooms.indexOf(members);
                //     if (index > -1) {
                //         this.rooms.splice(index, 1);
                //     }
                // }

            });
        },
        created() {
            // eventBus.$on('roomChanged',  (id)=> {
            //     this.getMembersFriends(id);
            // });

        }
    }
</script>
