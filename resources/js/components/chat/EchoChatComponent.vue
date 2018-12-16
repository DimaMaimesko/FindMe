<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        <textarea rows="10" class="form-control" readonly="true">
                            {{allMessages.join('\n')}}
                        </textarea>
                    </div>
                    <div class="card-body">
                        <input v-model="message" @keyup.enter="sendMessage" type="text" class="form-control" placeholder="Enter your message here and press Enter">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>



    export default {

        data: function(){
            return {
                allMessages: [],
                message: '',
            }
        },

        mounted() {
            window.Echo.channel('chat').listen('Message', ({message}) => {
                this.allMessages.push(message)
            });
        },

        methods:  {
            sendMessage: function () {
                axios.post('/frontend/chat/send', {body: this.message});
                this.allMessages.push(this.message)
                this.message = '';
                console.log(this.message);
            }
        }
    }
</script>
