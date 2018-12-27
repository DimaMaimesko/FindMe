<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">


                    <div class="card-header">Add friends:</div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:100px">Photo</th>
                                <th>Name</th>
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
                                <td>
                                    <input @change="changed(checkedFull)"  v-model="checkedFull[friend.id]"  type="checkbox">
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
                checkedFull: [],
            }
        },
        methods: {
            getFriends: function () {
                axios({
                    method: 'get',
                    url:    '/frontend/chat/rooms/get-friends',
                }).then((response) => {
                    this.friends = response.data.friends;
                    console.log(this.friends);
                });
            },

            changed: function (checkedFull) {

                checkedFull.forEach((item, i) => {
                    if ((item === true)){
                       this.checked[i] = item;
                    }else{
                        this.checked[i] = false;
                    }
                });
               console.log(this.checked);
               this.$emit('friendsList', this.checked);
            }
        },
        mounted() {
            this.getFriends();
        },
        created() {
            eventBus.$on('resetCheckedFriends', ()=>{
                this.checkedFull = [];
                this.checked = [];
            })
        }
    }
</script>

