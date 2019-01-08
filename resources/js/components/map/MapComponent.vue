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
             pos: {},
             marker: {},
             oldPosition: {
                 lat: 0,
                 lng: 0
             },
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

                 navigator.geolocation.watchPosition((position)=> {
                     let pos = {
                         lat: position.coords.latitude,
                         lng: position.coords.longitude
                     };
                     this.sendPosToServer(pos);
                     this.infoWindow.setPosition(pos);
                     this.infoWindow.setContent('Location found.');
                     this.infoWindow.open(this.map);
                     this.map.setCenter(pos);
                     this.marker = new google.maps.Marker({position: pos, map: this.map});

                 }, ()=> {
                     this.handleLocationError(true, this.infoWindow, this.map.getCenter());
                 });
             } else {
                 // Browser doesn't support Geolocation
                 this.handleLocationError(false, this.infoWindow, this.map.getCenter());
             };
             this.addMarker({lat: -34.497, lng: 150.644});
             this.addMarker({lat: -34.597, lng: 150.644});
          },

          addMarker: function(coords) {
               let marker = new google.maps.Marker({position: coords, map: this.map});

          },
          sendPosToServer: function(pos) {
              let newLat = pos.lat.toFixed(6);
              let newLng = pos.lng.toFixed(6);
              if ((newLat != this.oldPosition.lat) && (newLng != this.oldPosition.lng)){
                  this.sendNewCoordinates(newLat, newLng);
              }
              this.oldPosition.lat = newLat;
              this.oldPosition.lng = newLng;
          },
          sendNewCoordinates: function (newLat, newLng) {
              axios({
                  method: 'post',
                  url:    '/frontend/map/write-new-pos',
                  params: {lat: newLat, lng: newLng}
              }).then((response) => {
                 console.log(response.data.newPosition);
                 console.log(this.timeConverter(response.data.newTime));
              });
              // eventBus.$emit('resetCheckedFriends');
              // this.roomName = '';
          },

         handleLocationError: function(browserHasGeolocation, infoWindow, pos) {
             infoWindow.setPosition(pos);
             infoWindow.setContent(browserHasGeolocation ?
                 'Error: The Geolocation service failed.' :
                 'Error: Your browser doesn\'t support geolocation.');
             infoWindow.open(this.map);
         },
         timeConverter: function (UNIX_timestamp){
            let a = new Date(UNIX_timestamp * 1000);
            let months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            let year = a.getFullYear();
            let month = months[a.getMonth()];
            let date = a.getDate();
            let hour = a.getHours();
            let min = a.getMinutes();
            let sec = a.getSeconds();
            let time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
            return time;
    }

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

