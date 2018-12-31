<template>
    <div class="container">
        <div class="row justify-content-center">

                <h5>Wellcome, <span :class="nameClasses[0]">{{user.name}}</span></h5>
                <h5>Private room # {{room}}</h5>
                <h5>Active users in room:</h5>
                <ul>
                    <li v-for="user in activeUsers">{{user.name}}</li>
                </ul>

            <div class="container">
                <div style="height:300px;overflow-y:scroll;overflow-x: hidden">
                    <div v-if="(messages != [])" v-for="mess in messages" :class="user.id == mess.creator.id ? creatorClass : memberClass">
                        <p    :class="user.id == mess.creator.id ? nameClasses[0] : nameClasses[1]">{{mess.creator.name}}</p>
                        <span :class="user.id == mess.creator.id ? textClasses[0] : textClasses[1]" style="width: 90%">{{mess.text}}</span>
                    </div>
                    <div v-if="(newMessages != [])" v-for="mess in newMessages" :class="user.id == mess.creator.id ? creatorClass : memberClass">
                        <p    :class="user.id == mess.creator.id ? nameClasses[0] : nameClasses[1]">{{mess.creator.name}}</p>
                        <span :class="user.id == mess.creator.id ? textClasses[0] : textClasses[1]" style="width: 90%">{{mess.text}}</span>
                    </div>
                    <h4 id="fat"></h4>
                </div>

                  <input style="scrolling:auto" v-model="message"
                         @keyup.enter="sendMessage"
                         @keydown="userTyping"
                         type="text" class="form-control"
                         placeholder="Enter your message here and press Enter">

              <div v-if='isActive'  class="alert alert-info">{{isActive.name}} is typing...</div>
             </div>

        </div>
        <a href="#fat">Scroll</a>
    </div>
</template>

<script>


    import { eventBus } from "../../app";
    export default {

        props: {
          user: {},
        },

       data: function(){
           return {
               allMessages: [],
               message: '',
               isActive: false,
               typingTimer: false,
               activeUsers: [],
               room: '',
               previousRoom: '',
               messages: [],
               newMessages: [],
               nameClasses: [
                   "badge badge-pill badge-primary  mb-0",
                   "badge badge-pill badge-secondary  mb-0",
                   "badge badge-pill badge-success  mb-0",
                   "badge badge-pill badge-danger  mb-0",
                   "badge badge-pill badge-warning  mb-0",
                   "badge badge-pill badge-info  mb-0",
                   "badge badge-pill badge-light  mb-0",
                   "badge badge-pill badge-dark  mb-0",
               ],
               textClasses: [
                   "alert alert-primary mt-0",
                   "alert alert-secondary mt-0",
                   "alert alert-success mt-0",
                   "alert alert-danger mt-0",
                   "alert alert-warning mt-0",
                   "alert alert-info mt-0",
                   "alert alert-light mt-0",
                   "alert alert-dark mt-0",
               ],
               creatorClass: "d-flex flex-column align-items-start",
               memberClass: "d-flex flex-column align-items-end text-right",
           }
       },
        computed: {
            channel() {

                  return  window.Echo.join('room.' + this.room)
            }
        },

        created() {
            eventBus.$on('roomChanged',  (id)=> {
               window.Echo.leave('room.' + this.room);
               this.room = id;
               this.newMessages = [];
               this.messages = [];
               window.Echo.join('room.' + this.room).listen('PrivateMessage', ({message}) => {
                   this.newMessages.push(message);
                   this.isActive = false;
               });
               window.Echo.join('room.' + this.room).listenForWhisper('typing', (e) => {

                   this.isActive = e.name;

                   if(this.typingTimer) {
                       clearTimeout(this.typingTimer);
                   }

                   this.typingTimer = setTimeout(() => {
                       this.isActive = false;
                   }, 2000);

               });
                window.Echo.join('room.' + this.room).here((users) => {
                    this.activeUsers = users;
                });

                window.Echo.join('room.' + this.room).joining((user) => {
                    this.activeUsers.push(user);
                });

                window.Echo.join('room.' + this.room).leaving((user) => {
                    this.activeUsers.splice( this.activeUsers.indexOf(user), 1);
                });

                this.getMessages(this.room);
            });

            eventBus.$on('quitRoom',  (id)=> {
                window.Echo.leave('room.' + id);
                this.newMessages = [];
                this.messages = [];
                this.activeUsers = [];
            });
         },

        mounted() {

        },

        methods:  {
          sendMessage: function () {
              axios({
                  method: 'post',
                  url:    '/frontend/chat/send',
                  params: {message: this.message, room_id: this.room, user_id: this.user.id}
              }).then((response) => {
                  console.log('Data: '+response.data);
              });
              this.message = '';
          },
          userTyping: function () {
              window.Echo.join('room.' + this.room).whisper('typing', {name: this.user})
          },

          getMessages: function (id) {
              axios({
                  method: 'get',
                  url:    '/frontend/chat/get-messages',
                  params: {room_id: id}
              }).then((response) => {
                  this.messages = response.data.messages;
              });
          },
        }
    }
</script>
