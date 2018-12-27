<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="text-center">
                        <a :href="routeName" class="btn btn-success text-uppercase">My Page</a>
                    </div>

                    <div class="d-flex justify-content-around">
                        <div class="d-flex flex-column justify-content-around">
                            <label for="all">All</label>
                            <input @change="getUsers" type="radio" id="all" value="all" v-model="pickedGroup">
                        </div>
                        <div class="d-flex flex-column justify-content-around">
                            <label for="friends">Friends</label>
                            <input @change="getUsers"type="radio" id="friends" value="friends" v-model="pickedGroup">
                        </div>
                        <div class="d-flex flex-column justify-content-around">
                            <label for="followers">Followers</label>
                            <input @change="getUsers" type="radio" id="followers" value="followers" v-model="pickedGroup">
                        </div>
                        <div class="d-flex flex-column justify-content-around">
                            <label for="followees">Followees</label>
                            <input @change="getUsers" type="radio" id="followees" value="followees" v-model="pickedGroup">
                        </div>
                    </div>
                    <span>Picked: {{ pickedGroup }}</span>

                    <div class="card-header">All Users</div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width:100px">Photo</th>
                                <th>Name</th>
                                <th>Last seen</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr v-for="user in usersReactive" v-if="authUserId != user.id ">
                                <td>
                                    <a :href="user.photo">
                                        <img :src="user.thumbnail" alt="Photo" style="width:100%">
                                    </a>
                                </td>
                                <td>{{ user.name }}</td>
                                <td></td>
                                <td>
                                    <button v-if="!followeesReactive.includes(user.id)" @click="follow(user.id)" class="btn btn-success" style="width: 100%">Follow</button>
                                    <button v-if="followeesReactive.includes(user.id)"  @click="unfollow(user.id)" class="btn btn-warning"  style="width: 100%">Unfollow</button>
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
    export default {

        props: [
            'users',
            'authUserId',
            'followees',
        ],
        data: function(){
            return {
                followeesReactive: [],
                usersReactive: [],
                routeName: "/frontend/main",
                pickedGroup: 'all',
            }
        },
        methods: {
           follow: function (id) {
               axios({
                   method: 'post',
                   url:    '/frontend/home/follow',
                   params: {id: id, pickedGroup: this.pickedGroup}
               }).then((response) => {
                   this.usersReactive = response.data.users;
                   console.log(this.usersReactive);
                   this.followeesReactive = response.data.followees.map(function (strVal) {
                       return Number(strVal);
                   });
                   this.getUsers();
               });
           },
            unfollow: function (id) {
                axios({
                    method: 'post',
                    url:    '/frontend/home/unfollow',
                    params: {id: id, pickedGroup: this.pickedGroup}
                }).then((response) => {
                    this.followeesReactive = response.data.followees.map(function (strVal) {
                        return Number(strVal);
                    });
                    this.getUsers();
                });
            },
            getUsers: function () {
                axios({
                    method: 'post',
                    url:    '/frontend/home/get-users',
                    params: {pickedGroup: this.pickedGroup}
                }).then((response) => {
                    this.usersReactive = response.data.users;
                });
            },
        },
        mounted() {
            this.followeesReactive = this.followees.map(function (strVal) {
                return Number(strVal);
            });
            this.usersReactive = this.users;
            console.log(this.followeesReactive);
        }
    }
</script>

