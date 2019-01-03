<template>
    <div class="container">

        <div style="height: 300px" id="map"></div>


    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('Map mounted.')
        },

     data: function(){
         return {
             map:{},
             infoWindow: {},
         }
     },
        methods: {


      initMap: function() {
         this.map = new google.maps.Map(document.getElementById('map'), {
             center: {lat: -34.397, lng: 150.644},
             zoom: 8
         });
          this.infoWindow = new google.maps.InfoWindow;
         // Try HTML5 geolocation.
         if (navigator.geolocation) {
             navigator.geolocation.getCurrentPosition((position)=> {
                 var pos = {
                     lat: position.coords.latitude,
                     lng: position.coords.longitude
                 };
                 console.log(pos.lat);
                 console.log(pos.lng);

                 this.infoWindow.setPosition(pos);
                 this.infoWindow.setContent('Location found.');
                 this.infoWindow.open(this.map);
                 this.map.setCenter(pos);
             }, ()=> {
                 this.handleLocationError(true, this.infoWindow, this.map.getCenter());
             });
         } else {
             // Browser doesn't support Geolocation
             this.handleLocationError(false, this.infoWindow, this.map.getCenter());
         }
     },

     handleLocationError: function(browserHasGeolocation, infoWindow, pos) {
         infoWindow.setPosition(pos);
         infoWindow.setContent(browserHasGeolocation ?
             'Error: The Geolocation service failed.' :
             'Error: Your browser doesn\'t support geolocation.');
         infoWindow.open(this.map);
     },

        }
    }
</script>

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    /*#map {*/
        /*height: 100%;*/
    /*}*/
    /* Optional: Makes the sample page fill the window. */
    /*html, body {*/
        /*height: 100%;*/
        /*margin: 0;*/
        /*padding: 0;*/
    /*}*/
</style>

