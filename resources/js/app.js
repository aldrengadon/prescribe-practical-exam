/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('notification-fail', require('./components/notification/notificationFail.vue').default);
Vue.component('notification-success', require('./components/notification/notificationSuccess.vue').default);
Vue.component('notification-notice', require('./components/notification/notificationNotice.vue').default);

Vue.component('welcome-index', require('./components/modules/welcome/index.vue').default);
Vue.component('user-index', require('./components/modules/user/index.vue').default);
Vue.component('user-create', require('./components/modules/user/create.vue').default);
Vue.component('user-update', require('./components/modules/user/update.vue').default);
Vue.component('user-delete', require('./components/modules/user/delete.vue').default);

Vue.component('role-index', require('./components/modules/role/index.vue').default);
Vue.component('role-update', require('./components/modules/role/update.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});
