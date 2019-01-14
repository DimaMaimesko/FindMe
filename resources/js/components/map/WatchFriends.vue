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
                                <th>Show</th>
                                <th>Find</th>
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
                                <td>{{timeConverter(friend.last_seen)}}</td>
                                <td>
                                    <input
                                        @change="changed(checkedAfter[friend.id], friend)"
                                        v-model="checkedAfter[friend.id]" type="checkbox">
                                </td>
                                <td>
                                    <button v-if="checkedAfter[friend.id]" @click="locateFriend(friend)">Find</button>
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
                 checked: [],
                 checkedAfter: [],
            }
        },
        methods: {
            getAllFriends:  function() {
                axios({
                    method: 'get',
                    url:    '/frontend/map/get-all-friends',
                }).then((response) => {
                    this.friends = response.data.friends;
                });
            },
            timeConverter: function (UNIX_timestamp){
                if (UNIX_timestamp){
                    let a = new Date(UNIX_timestamp * 1000);
                    let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    let year = a.getFullYear();
                    let month = months[a.getMonth()];
                    let date = ('0' + a.getDate()).slice(-2);
                    let hour = ('0' + a.getHours()).slice(-2);
                    let min = ('0' + a.getMinutes()).slice(-2);
                    //let sec = a.getSeconds();
                    let time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min;
                    return time;
                }

            },
            locateFriend: function (friend) {
                eventBus.$emit('locateFriend', friend);
            },

            changed: function (value, friend) {
                if (this.checked.includes(friend.id)){
                    if (value == false){
                        let index = this.checked.indexOf(friend.id);
                        if (index > -1) {
                            this.checked.splice(index, 1);
                        }
                    }
                }else{
                    if (value == true){
                        this.checked.push(friend.id)
                    }
                }
                if (value) {
                    eventBus.$emit('addFriendOnMap', [friend, this.checked])
                }else{
                    eventBus.$emit('removeFriendFromMap', [friend, this.checked])
                }
            }
        },
        mounted() {
            this.getAllFriends();
            window.Echo.channel('private-coordchanged').listen('CoordChanged', ({lat, lng, time, user_id}) => {
                let moovingFriend = this.friends.find((friend)=>{
                    return friend.id == user_id;
                });
            console.log("Friend");
            console.log(moovingFriend);
                let moovingFriendIndex = this.friends.findIndex((friend)=>{
                    return friend.id == user_id;
                });
                moovingFriend.coords = {lat: lat,lng: lng};
                moovingFriend.last_seen = time;
                moovingFriend.user_id = user_id;
                this.friends[moovingFriendIndex] = moovingFriend;
                eventBus.$emit('showFriendOnMap', moovingFriend);
            });
        },
        created() {
            eventBus.$on('getFriendsAgain',  ()=> {
                this.getAllFriends;
            });

        }
    }
</script>
