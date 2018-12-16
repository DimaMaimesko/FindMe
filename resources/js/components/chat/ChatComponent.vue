<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h3>Chat</h3>
                <echo-chat-component></echo-chat-component>

            </div>
            <div class="col-md-6">

                <h3>Rooms</h3>

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
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
