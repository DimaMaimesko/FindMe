<template>
    <div class="container">
        <div class="row justify-content-center">

                <h3>Wellcome, {{user.name}}</h3>
                <h3>Private room # {{room}}</h3>
                <!--<h5>for next users:</h5>-->
                <!--<ul v-for="user in room.users">{{user.name}}</ul>-->
                <hr>
                <h5>Active users in room:</h5>
                <ul>
                    <li v-for="user in activeUsers">{{user}}</li>
                </ul>

                <div class="card card-default">
                    <div class="card-header">
                        <textarea rows="10" class="form-control" readonly="true">
                            {{allMessages.join('\n')}}
                        </textarea>
                    </div>
                    <div class="card-body">
                      <input v-model="message"
                             @keyup.enter="sendMessage"
                             @keydown="userTyping"
                             type="text" class="form-control"
                             placeholder="Enter your message here and press Enter">
                    </div>
                    <div v-if='isActive'  class="alert alert-info">{{isActive}} is typing...</div>
                </div>

        </div>
    </div>
</template>

<script>


    import { eventBus } from "../../app";
    export default {

        props: {
          // room: {},
          user: {},
        },

       data: function(){
           return {
               allMessages: [],
               message: '',
               isActive: false,
               typingTimer: false,
               activeUsers: [],
               room: 1,
           }
       },
        computed: {
            channel() {
                  return  window.Echo.join('room.' + this.room)
            }
        },

        created() {
            eventBus.$on('roomChanged',  (id)=> {
               this.room = id;
            });
         },

        mounted() {
           this.channel.listen('PrivateMessage', ({message}) => {
               this.allMessages.push(message);
               this.isActive = false;
           });

           this.channel.listenForWhisper('typing', (e) => {

               this.isActive = e.name;

               if(this.typingTimer) {
                   clearTimeout(this.typingTimer);
               }

               this.typingTimer = setTimeout(() => {
                   this.isActive = false;
               }, 2000);

           });

           this.channel.here((users) => {
               this.activeUsers = users;
           });

           this.channel.joining((user) => {
               this.activeUsers.push(user);
           });

           this.channel.leaving((user) => {
               this.activeUsers.splice( this.activeUsers.indexOf(user), 1);
           });
        },

        methods:  {
          sendMessage: function () {
              axios({
                  method: 'post',
                  url:    '/frontend/chat/send',
                  params: {message: this.message, room_id: this.room}
              }).then((response) => {
                  console.log('Data: '+response.data);
              });
              this.allMessages.push(this.message)
              this.message = '';
          },
          userTyping: function () {
              this.channel.whisper('typing', {name: this.user})
          }
        }
    }
</script>
