<template>
    <div class="container">
        <button @click="findMe()">Find Me</button>

        <div style="height: 300px" id="map"></div>


    </div>
</template>

<script>
    import { eventBus } from "../../app";

    export default {
        mounted() {
            console.log('Map mounted.')
        },

        data: function(){
             return {
                 map:{},
                 infoWindow: {},
                 pos: {},
                 markerAuth: {},
                 markers: [],
                 oldPosition: {
                     lat: 0,
                     lng: 0
                 },
                 markersToMap: {},
                 checked: [],
                 wathingAnotherUser: 'start',
             }
        },
        created() {
            eventBus.$on('addFriendOnMap', (params)=>{
                this.checked = params[1];
                let friend = params[0];
                let lat = friend.coords.lat;
                let lng = friend.coords.lng;
                lat = parseFloat(lat);
                lng = parseFloat(lng);
                let coords = {lat: lat,lng: lng};
                let last_seen = JSON.parse(friend.last_seen);
                this.addMarkerToArray(coords, last_seen, friend);
            }),

            eventBus.$on('removeFriendFromMap', (params)=>{
                let friend = params[0];
                this.removeMarkerFromArray(friend) ;
            }),

            eventBus.$on('showFriendOnMap', (moovingFriend)=>{
                if (this.checked.includes(moovingFriend.id)){
                    let lat = moovingFriend.coords.lat;
                    let lng = moovingFriend.coords.lng;
                    lat = parseFloat(lat);
                    lng = parseFloat(lng);
                    let coords = {lat: lat,lng: lng};
                    this.addMarkerToArray(coords, moovingFriend.last_seen, moovingFriend) ;
                }
            });

            eventBus.$on('locateFriend', (friend)=>{
                this.wathingAnotherUser = "Yes";
                let lat = friend.coords.lat;
                let lng = friend.coords.lng;
                lat = parseFloat(lat);
                lng = parseFloat(lng);
                let coords = {lat: lat,lng: lng};
                this.map.setCenter(coords);
            });

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

                     if ((this.wathingAnotherUser === 'start') || (this.wathingAnotherUser === 'false')){
                         this.infoWindow.setPosition(pos);
                         this.infoWindow.setContent("It's Me");
                         this.infoWindow.open(this.map);
                         this.map.setCenter(pos);
                         if (!this.isEmpty(this.markerAuth)){
                             this.markerAuth.setMap(null);
                             this.markerAuth = null;
                         }
                         this.markerAuth = new google.maps.Marker({position: pos, title:"I'm here"});
                         this.markerAuth.setMap(this.map);
                     }

                 }, ()=> {
                     this.handleLocationError(true, this.infoWindow, this.map.getCenter());
                 });
             } else {
                 // Browser doesn't support Geolocation
                 this.handleLocationError(false, this.infoWindow, this.map.getCenter());
             };
          },

          addMarkerToArray: function(coords, last_seen, friend) {
              if (!this.isEmpty(this.markers)){

                  if ( typeof this.markers[friend.id] !== 'undefined'){
                      this.markers[friend.id].setMap(null);
                      this.markers[friend.id] = null;
                  };
                  if (this.checked.includes(friend.id)){
                      this.markers[friend.id] = {
                          'coords': coords,
                          'last_seen': last_seen,
                  };
                  this.markers[friend.id] = new google.maps.Marker({position: coords, title:friend.name});
                  this.markers[friend.id].setMap(this.map);
                  }
              }
          },
            removeMarkerFromArray: function(friend) {
              if (!this.isEmpty(this.markers)){

                  if ( typeof this.markers[friend.id] !== 'undefined'){
                      this.markers[friend.id].setMap(null);
                  };
              }
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
                 if (this.wathingAnotherUser === 'false'){
                     this.map.setCenter({
                         lat: parseFloat(newLat),
                         lng: parseFloat(newLng),
                     });

                 }
              });
          },
            isEmpty: function(obj) {
                 for(let prop in obj) {
                      if(obj.hasOwnProperty(prop))
                      return false;
                 }
                 return JSON.stringify(obj) === JSON.stringify({});
            },
            findMe: function() {
                this.wathingAnotherUser = 'false';
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
</style>

