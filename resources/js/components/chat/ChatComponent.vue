<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h3>Chat</h3>
                <private-echo-chat-component :user="user" :room="room"></private-echo-chat-component>

            </div>
            <div class="col-md-6">

                <h3>Rooms</h3>
                <rooms-component></rooms-component>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h3>Participants</h3>

            </div>
            <div class="col-md-6">

                <h3>Friends</h3>

            </div>
        </div>
    </div>
</template>

<script>
    import RoomsComponent from "./RoomsComponent";
    export default {
        components: {RoomsComponent},
        props: [
            'user',
            'room',

        ],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
