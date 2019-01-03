
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./MyScripts');

window.Vue = require('vue');

export const eventBus = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/MapComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('users-table', require('./components/UsersTable.vue'));

Vue.component('chat-component', require('./components/chat/ChatComponent.vue'));
Vue.component('private-echo-chat-component', require('./components/chat/PrivateEchoChatComponent.vue'));
Vue.component('rooms-component', require('./components/chat/RoomsComponent.vue'));
Vue.component('friends-for-room', require('./components/chat/FriendsForRoom.vue'));
Vue.component('members-in-room', require('./components/chat/MembersInRoom.vue'));

Vue.component('map-component', require('./components/map/MapComponent.vue'));
Vue.component('watch-friends', require('./components/map/WatchFriends.vue'));

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
window.app = app;

//
// $("[data-confirm]").click(function() {
//     return confirm($(this).attr('data-confirm'));
// });
